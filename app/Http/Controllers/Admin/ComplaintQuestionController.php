<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintQuestion;
use App\Models\ComplaintQuestionOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintQuestionController extends Controller
{
    public function index(): View
    {
        $questions = ComplaintQuestion::query()->orderBy('sort_order')->with('options')->get();

        return view('admin.settings.questions.index', compact('questions'));
    }

    public function create(): View
    {
        return view('admin.settings.questions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedQuestion($request);

        if ($data['type'] === ComplaintQuestion::TYPE_SELECTION) {
            $request->validate([
                'options' => ['required', 'array', 'min:1'],
                'options.*' => ['nullable', 'string', 'max:255'],
            ]);
        }

        $question = ComplaintQuestion::query()->create([
            'prompt' => $data['prompt'],
            'prompt_bn' => $data['prompt_bn'] ?? null,
            'type' => $data['type'],
            'allow_multiple' => $data['type'] === ComplaintQuestion::TYPE_SELECTION
                ? $request->boolean('allow_multiple')
                : false,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'is_filterable' => $request->boolean('is_filterable', false),
        ]);

        $this->syncOptions($question, $request);

        return redirect()->route('admin.settings.questions.index')->with('success', __('Question created.'));
    }

    public function edit(ComplaintQuestion $question): View
    {
        $question->load('options');

        return view('admin.settings.questions.edit', compact('question'));
    }

    public function update(Request $request, ComplaintQuestion $question): RedirectResponse
    {
        $data = $this->validatedQuestion($request);

        if ($data['type'] === ComplaintQuestion::TYPE_SELECTION) {
            $request->validate([
                'options' => ['required', 'array', 'min:1'],
                'options.*' => ['nullable', 'string', 'max:255'],
            ]);
        }

        $question->update([
            'prompt' => $data['prompt'],
            'prompt_bn' => $data['prompt_bn'] ?? null,
            'type' => $data['type'],
            'allow_multiple' => $data['type'] === ComplaintQuestion::TYPE_SELECTION
                ? $request->boolean('allow_multiple')
                : false,
            'sort_order' => $data['sort_order'] ?? $question->sort_order,
            'is_active' => $request->boolean('is_active', $question->is_active),
            'is_filterable' => $request->boolean('is_filterable', $question->is_filterable),
        ]);

        if ($question->type === ComplaintQuestion::TYPE_SELECTION) {
            $question->options()->delete();
            $this->syncOptions($question, $request);
        } else {
            $question->options()->delete();
        }

        return redirect()->route('admin.settings.questions.index')->with('success', __('Question updated.'));
    }

    public function destroy(ComplaintQuestion $question): RedirectResponse
    {
        // Don't allow deletion if it has answers
        $hasAnswers = \App\Models\ComplaintAnswer::where('complaint_question_id', $question->id)->exists();
        if ($hasAnswers) {
            return redirect()->back()->with('error', __('Cannot delete question because it is in use by complaints.'));
        }

        $question->delete();

        return redirect()->route('admin.settings.questions.index')->with('success', __('Question deleted.'));
    }

    public function restore(string $id): RedirectResponse
    {
        $question = ComplaintQuestion::withTrashed()->findOrFail($id);
        $question->restore();

        return redirect()->route('admin.settings.questions.index')->with('success', __('Question restored.'));
    }

    private function validatedQuestion(Request $request): array
    {
        return $request->validate([
            'prompt' => ['required', 'string', 'max:500'],
            'prompt_bn' => ['nullable', 'string', 'max:500'],
            'type' => ['required', Rule::in([
                ComplaintQuestion::TYPE_TEXT,
                ComplaintQuestion::TYPE_TEXTAREA,
                ComplaintQuestion::TYPE_EMAIL,
                ComplaintQuestion::TYPE_PHONE,
                ComplaintQuestion::TYPE_SELECTION,
                ComplaintQuestion::TYPE_BOOLEAN,
                ComplaintQuestion::TYPE_FILE,
            ])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function syncOptions(ComplaintQuestion $question, Request $request): void
    {
        if ($question->type !== ComplaintQuestion::TYPE_SELECTION) {
            return;
        }

        $labels = array_values(array_filter(array_map('trim', $request->input('options', [])), fn ($l) => $l !== ''));

        foreach ($labels as $i => $label) {
            ComplaintQuestionOption::query()->create([
                'complaint_question_id' => $question->id,
                'label' => $label,
                'sort_order' => ($i + 1) * 10,
            ]);
        }
    }
}
