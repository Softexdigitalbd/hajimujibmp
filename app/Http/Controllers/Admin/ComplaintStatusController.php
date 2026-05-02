<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintStatusController extends Controller
{
    public function index(): View
    {
        $statuses = ComplaintStatus::query()->orderBy('sort_order')->get();

        return view('admin.settings.statuses.index', compact('statuses'));
    }

    public function create(): View
    {
        return view('admin.settings.statuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:64', 'regex:/^[a-z0-9_]+$/', 'unique:complaint_statuses,name'],
            'alias_name' => ['required', 'string', 'max:255'],
            'state' => ['required', Rule::in([
                ComplaintStatus::STATE_STARTED,
                ComplaintStatus::STATE_PROCESSING,
                ComplaintStatus::STATE_RESOLUTION,
            ])],
            'color' => ['required', 'string', 'max:32'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        ComplaintStatus::query()->create([
            ...$data,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.settings.statuses.index')->with('success', __('Status created.'));
    }

    public function edit(ComplaintStatus $status): View
    {
        return view('admin.settings.statuses.edit', compact('status'));
    }

    public function update(Request $request, ComplaintStatus $status): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:64', 'regex:/^[a-z0-9_]+$/', Rule::unique('complaint_statuses', 'name')->ignore($status->id)],
            'alias_name' => ['required', 'string', 'max:255'],
            'state' => ['required', Rule::in([
                ComplaintStatus::STATE_STARTED,
                ComplaintStatus::STATE_PROCESSING,
                ComplaintStatus::STATE_RESOLUTION,
            ])],
            'color' => ['required', 'string', 'max:32'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $status->update([
            ...$data,
            'is_active' => $request->boolean('is_active', $status->is_active),
        ]);

        return redirect()->route('admin.settings.statuses.index')->with('success', __('Status updated.'));
    }

    public function destroy(ComplaintStatus $status)
    {
        // Don't allow deletion if it has complaints or is used in transitions
        $hasComplaints = \App\Models\Complaint::where('complaint_status_id', $status->id)->exists();
        if ($hasComplaints) {
            return redirect()->back()->with('error', __('Cannot delete status because it is in use by complaints.'));
        }

        $status->delete();
        return redirect()->route('admin.settings.statuses.index')->with('success', __('Status deleted.'));
    }

    public function restore(string $id): RedirectResponse
    {
        $status = ComplaintStatus::withTrashed()->findOrFail($id);
        $status->restore();

        return redirect()->route('admin.settings.statuses.index')->with('success', __('Status restored.'));
    }

    public function trash(): View
    {
        $statuses = ComplaintStatus::onlyTrashed()->orderByDesc('deleted_at')->get();
        $questions = \App\Models\ComplaintQuestion::onlyTrashed()->orderByDesc('deleted_at')->get();

        return view('admin.settings.statuses.trash', compact('statuses', 'questions'));
    }
}
