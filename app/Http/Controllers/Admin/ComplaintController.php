<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Complaint;
use App\Models\ComplaintAnswer;
use App\Models\ComplaintStatusTransition;
use App\Services\AuditLogger;
use App\Services\ComplaintTransitionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function __construct(
        private ComplaintTransitionService $transitionService
    ) {}

    public function index(Request $request): View
    {
        $query = Complaint::query()
            ->with(['status', 'answers.question'])
            ->latest();

        if ($request->filled('status_id')) {
            $query->where('complaint_status_id', $request->integer('status_id'));
        }

        if ($request->filled('q')) {
            $q = '%'.$request->string('q')->trim().'%';
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('answers', fn ($a) => $a->where('value', 'like', $q));
            });
        }

        if (is_array($request->input('filters'))) {
            foreach ($request->input('filters') as $qId => $value) {
                if (!empty($value)) {
                    $query->whereHas('answers', function ($a) use ($qId, $value) {
                        $a->where('complaint_question_id', $qId)
                          ->where('value', 'like', '%' . $value . '%');
                    });
                }
            }
        }

        $complaints = $query->orderByDesc('id')->paginate(20)->withQueryString();
        $statuses = \App\Models\ComplaintStatus::query()->active()->orderBy('sort_order')->get();
        $filterQuestions = \App\Models\ComplaintQuestion::query()
            ->where('is_filterable', true)
            ->with('options')
            ->get();

        return view('admin.complaints.index', compact('complaints', 'statuses', 'filterQuestions'));
    }

    public function show(Complaint $complaint): View
    {
        $complaint->load([
            'status',
            'answers.question',
            'auditLogs.user',
            'auditLogs.fromStatus',
            'auditLogs.toStatus',
            'auditLogs.comment.user',
        ]);

        $allowedTransitions = ComplaintStatusTransition::query()
            ->where('from_complaint_status_id', $complaint->complaint_status_id)
            ->with('toStatus')
            ->get()
            ->pluck('toStatus')
            ->filter(fn ($s) => $s && $s->is_active)
            ->unique('id')
            ->values();

        return view('admin.complaints.show', compact('complaint', 'allowedTransitions'));
    }

    public function updateStatus(Request $request, Complaint $complaint): RedirectResponse
    {
        $request->validate([
            'complaint_status_id' => ['required', 'integer', 'exists:complaint_statuses,id'],
        ]);

        $this->transitionService->transition(
            $complaint,
            $request->integer('complaint_status_id'),
            (int) $request->user()->id
        );

        return back()->with('success', __('Complaint updated.'));
    }

    public function storeComment(Request $request, Complaint $complaint): RedirectResponse
    {
        $request->validate([
            'body' => ['required', 'string', 'max:10000'],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx'],
        ]);

        $path = null;
        $original = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $original = $file->getClientOriginalName();
            $path = $file->store('comment-attachments/'.$complaint->id, 'local');
        }

        $comment = Comment::query()->create([
            'complaint_id' => $complaint->id,
            'user_id' => $request->user()->id,
            'body' => $request->string('body')->toString(),
            'attachment_path' => $path,
            'original_filename' => $original,
        ]);

        AuditLogger::logComment($complaint, $comment->id, (int) $request->user()->id);

        return back()->with('success', __('Note added.'));
    }

    public function downloadAttachment(Complaint $complaint, Comment $comment)
    {
        if ($comment->complaint_id !== $complaint->id || ! $comment->attachment_path) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($comment->attachment_path)) {
            abort(404);
        }

        return Storage::disk('local')->download(
            $comment->attachment_path,
            $comment->original_filename ?? 'attachment'
        );
    }

    public function downloadAnswerFile(Complaint $complaint, ComplaintAnswer $answer)
    {
        if ($answer->complaint_id !== $complaint->id) {
            abort(404);
        }

        $decoded = json_decode($answer->value, true);
        // Support both formats: array-of-files [{path,original},...] and legacy single {path,original}
        $meta     = is_array($decoded) ? (isset($decoded['path']) ? $decoded : ($decoded[0] ?? [])) : [];
        $path     = $meta['path'] ?? null;
        $original = $meta['original'] ?? null;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, $original ?? 'evidence');
    }

    public function inlineAnswerFile(Complaint $complaint, ComplaintAnswer $answer): Response
    {
        if ($answer->complaint_id !== $complaint->id) {
            abort(404);
        }

        $decoded = json_decode($answer->value, true);
        $meta    = is_array($decoded) ? (isset($decoded['path']) ? $decoded : ($decoded[0] ?? [])) : [];
        $path    = $meta['path'] ?? null;

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $mime = Storage::disk('local')->mimeType($path);

        return response(Storage::disk('local')->get($path), 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline',
        ]);
    }

    public function inlineAttachment(Complaint $complaint, Comment $comment): Response
    {
        if ($comment->complaint_id !== $complaint->id || ! $comment->attachment_path) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($comment->attachment_path)) {
            abort(404);
        }

        $mime = Storage::disk('local')->mimeType($comment->attachment_path);

        return response(Storage::disk('local')->get($comment->attachment_path), 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline',
        ]);
    }
}
