<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\ComplaintStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BehaviourSettingsController extends Controller
{
    public function edit(): View
    {
        $setting = AppSetting::query()->first();
        abort_if(! $setting, 503, __('Application settings are not initialized. Please run the database seeder (e.g. php artisan db:seed).'));

        $statuses = ComplaintStatus::query()->active()->orderBy('sort_order')->get();
        $filterQuestions = \App\Models\ComplaintQuestion::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.settings.behaviour', compact('setting', 'statuses', 'filterQuestions'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'new_complaint_status_id' => ['required', 'exists:complaint_statuses,id'],
            'reopen_status_id' => ['required', 'exists:complaint_statuses,id'],
            'filterable_questions' => ['nullable', 'array'],
            'filterable_questions.*' => ['integer', 'exists:complaint_questions,id'],
        ]);

        $setting = AppSetting::query()->firstOrFail();
        $setting->update([
            'new_complaint_status_id' => $request->integer('new_complaint_status_id'),
            'reopen_status_id' => $request->integer('reopen_status_id'),
        ]);

        \App\Models\ComplaintQuestion::query()->update(['is_filterable' => false]);
        if ($request->filled('filterable_questions')) {
            \App\Models\ComplaintQuestion::whereIn('id', $request->input('filterable_questions'))->update(['is_filterable' => true]);
        }

        return back()->with('success', __('Settings saved.'));
    }
}
