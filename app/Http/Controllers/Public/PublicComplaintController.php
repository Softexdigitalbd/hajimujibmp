<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Complaint;
use App\Models\ComplaintAnswer;
use App\Models\ComplaintQuestion;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicComplaintController extends Controller
{
    public function create(): View
    {
        $questions = ComplaintQuestion::query()->activeOrdered()->with('options')->get();
        $settingsConfigured = AppSetting::query()->whereNotNull('new_complaint_status_id')->exists();

        return view('public.complaint-create', compact('questions', 'settingsConfigured'));
    }

    public function store(Request $request): RedirectResponse
    {
        $questions = ComplaintQuestion::query()->activeOrdered()->with('options')->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('complaint.create')
                ->withErrors(['form' => __('The complaint form has no active questions. Please try again later.')]);
        }

        $settings = AppSetting::query()->first();
        if (! $settings || ! $settings->new_complaint_status_id) {
            return redirect()
                ->route('complaint.create')
                ->withErrors(['form' => __('Complaints cannot be accepted right now. Please try again later.')]);
        }

        $newStatusId = (int) $settings->new_complaint_status_id;

        $rules = [];
        $attributes = [];
        foreach ($questions as $question) {
            $rules = array_merge($rules, $this->rulesForQuestion($question));
            $attributes['answers.'.$question->id] = $question->prompt;
        }

        $messages = [
            'answers.*.regex' => __('Special characters are not allowed (বিশেষ অক্ষর অনুমোদিত নয়)'),
            'answers.*.digits' => __('Must be exactly 11 digits (অবশ্যই ১১ সংখ্যার হতে হবে)'),
        ];

        $validated = $request->validate(array_merge($rules, [
            'is_confidential' => ['nullable', 'boolean'],
        ]), $messages, $attributes);

        $complaint = null;
        DB::transaction(function () use ($questions, $validated, $newStatusId, $request, &$complaint) {
            $reference = $this->uniquePublicReference();

            $complaint = Complaint::query()->create([
                'public_reference' => $reference,
                'complaint_status_id' => $newStatusId,
                'is_confidential' => (bool) ($validated['is_confidential'] ?? false),
            ]);

            foreach ($questions as $question) {
                $value = match ($question->type) {
                    ComplaintQuestion::TYPE_FILE => $this->storeEvidenceAnswer($request, $complaint->id, $question->id),
                    default => $this->normalizeAnswerValue(
                        $question,
                        $validated['answers'][$question->id] ?? null
                    ),
                };

                ComplaintAnswer::query()->create([
                    'complaint_id' => $complaint->id,
                    'complaint_question_id' => $question->id,
                    'value' => $value,
                ]);
            }

            AuditLogger::logStatusChange($complaint, null, $newStatusId, null);
        });

        return redirect()
            ->route('complaint.thanks', ['reference' => $complaint->public_reference])
            ->with('success', __('Your complaint (Reference: :ref) has been submitted successfully. (আপনার অভিযোগটি সফলভাবে জমা দেওয়া হয়েছে। রেফারেন্স: :ref)', ['ref' => $complaint->public_reference]));
    }

    public function thanks(string $reference): View
    {
        $complaint = Complaint::query()->where('public_reference', $reference)->firstOrFail();

        return view('public.complaint-thanks', compact('complaint'));
    }

    private function storeEvidenceAnswer(Request $request, int $complaintId, int $questionId): string
    {
        $files = $request->file('answers.'.$questionId);
        if (! is_array($files)) {
            $files = $files ? [$files] : [];
        }

        $results = [];
        foreach ($files as $file) {
            if ($file && $file->isValid()) {
                $results[] = [
                    'path' => $file->store('complaint-evidence/'.$complaintId, 'local'),
                    'original' => $file->getClientOriginalName(),
                ];
            }
        }

        return empty($results) ? '' : json_encode($results, JSON_THROW_ON_ERROR);
    }

    private function uniquePublicReference(): string
    {
        $lastComplaint = Complaint::query()->orderBy('id', 'desc')->first();
        $nextId = $lastComplaint ? $lastComplaint->id + 1 : 1;
        
        while (Complaint::query()->where('public_reference', 'CMP-' . $nextId)->exists()) {
            $nextId++;
        }

        return 'CMP-' . $nextId;
    }

    /**
     * @return array<string, mixed>
     */
    private function rulesForQuestion(ComplaintQuestion $question): array
    {
        $key = 'answers.'.$question->id;

        return match ($question->type) {
            ComplaintQuestion::TYPE_TEXT => [
                $key => array_merge(['required', 'string', 'max:500'], 
                    (str_contains(strtolower($question->prompt), 'name') || str_contains($question->prompt, 'নাম')) 
                    ? ['regex:/^[a-zA-Z\s\p{Bengali}\.]+$/u'] 
                    : []
                ),
            ],
            ComplaintQuestion::TYPE_PHONE => [
                $key => ['required', 'digits:11'],
            ],
            ComplaintQuestion::TYPE_TEXTAREA => [
                $key => ['required', 'string', 'max:10000'],
            ],
            ComplaintQuestion::TYPE_EMAIL => [
                $key => ['required', 'email', 'max:255'],
            ],
            ComplaintQuestion::TYPE_SELECTION => $this->selectionRules($question, $key),
            ComplaintQuestion::TYPE_BOOLEAN => [
                $key => ['nullable', 'in:0,1'],
            ],
            ComplaintQuestion::TYPE_FILE => [
                $key => ['nullable', 'array'],
                $key.'.*' => ['file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx'],
            ],
            default => [
                $key => ['required', 'string', 'max:2000'],
            ],
        };
    }

    private function selectionRules(ComplaintQuestion $question, string $key): array
    {
        $optionIds = $question->options->pluck('id')->all();
        $inRule = Rule::in($optionIds);

        if ($question->allow_multiple) {
            return [
                $key => ['required', 'array', 'min:1'],
                $key.'.*' => ['integer', $inRule],
            ];
        }

        return [
            $key => ['required', 'integer', $inRule],
        ];
    }

    private function normalizeAnswerValue(ComplaintQuestion $question, mixed $raw): string
    {
        if ($question->type === ComplaintQuestion::TYPE_BOOLEAN) {
            return ((string) $raw === '1') ? '1' : '0';
        }

        if ($question->type !== ComplaintQuestion::TYPE_SELECTION) {
            return is_string($raw) ? $raw : (string) $raw;
        }

        if ($question->allow_multiple) {
            $ids = is_array($raw) ? $raw : [];
            $labels = $question->options->whereIn('id', $ids)->pluck('label')->values()->all();

            return json_encode($labels, JSON_THROW_ON_ERROR);
        }

        $option = $question->options->firstWhere('id', (int) $raw);

        return $option?->label ?? '';
    }
}
