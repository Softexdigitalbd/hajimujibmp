@extends('layouts.admin')

@section('title', __('Complaint behaviour'))
@section('heading', __('Complaint behaviour'))
@section('subheading', __('Choose which status new complaints start in, and which status is used when you reopen a closed complaint.'))

@section('content')
    <div class="w-full space-y-6">
        <form method="POST" action="{{ route('admin.settings.behaviour.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                {{-- New Complaint Status --}}
                <div class="group flex flex-col rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all hover:border-emerald-200 hover:shadow-md">
                    <div class="mb-5 flex items-center gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 shadow-sm ring-1 ring-emerald-500/10 transition-transform group-hover:scale-110">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">{{ __('New Submissions') }}</h3>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Initial State') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex-1 space-y-4">
                        <p class="text-xs font-medium leading-relaxed text-slate-500">
                            {{ __('Choose the stage every new public submission starts in. This is usually "Received" or "Pending Review".') }}
                        </p>
                        <select name="new_complaint_status_id" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20" required>
                            @foreach($statuses as $st)
                                <option value="{{ $st->id }}" @selected($setting->new_complaint_status_id == $st->id)>{{ $st->alias_name }} ({{ $st->state }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Reopen Status --}}
                <div class="group flex flex-col rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all hover:border-violet-200 hover:shadow-md">
                    <div class="mb-5 flex items-center gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 shadow-sm ring-1 ring-violet-500/10 transition-transform group-hover:scale-110">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-800">{{ __('Reopening Activity') }}</h3>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Workflow Reset') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex-1 space-y-4">
                        <p class="text-xs font-medium leading-relaxed text-slate-500">
                            {{ __('When moving a complaint from a closed outcome back into progress, it must use this status to restart the process.') }}
                        </p>
                        <select name="reopen_status_id" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20" required>
                            @foreach($statuses as $st)
                                <option value="{{ $st->id }}" @selected($setting->reopen_status_id == $st->id)>{{ $st->alias_name }} ({{ $st->state }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Filterable Fields --}}
            <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-5">
                    <div class="flex items-center gap-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 shadow-sm ring-1 ring-sky-500/10">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-[13px] font-extrabold text-slate-800">{{ __('Filterable Fields') }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ __('List Customization') }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-xs font-medium leading-relaxed text-slate-500 mb-6">
                        {{ __('Select which dropdown questions should appear as filters above the complaints list. "Status" is always included automatically.') }}
                    </p>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($filterQuestions as $fq)
                            <label class="group relative flex items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4 transition-all hover:bg-slate-50 cursor-pointer has-[:checked]:border-sky-300 has-[:checked]:bg-sky-50/30 has-[:checked]:shadow-sm">
                                <div class="mt-0.5 relative flex items-center justify-center">
                                    <input type="checkbox" name="filterable_questions[]" value="{{ $fq->id }}" @checked($fq->is_filterable) class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500/20">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-slate-700 group-hover:text-slate-900 transition-colors">{{ $fq->prompt }}</p>
                                    @if(filled($fq->prompt_bn))
                                        <p class="mt-1 text-[11px] font-medium text-slate-400 noto-bn group-hover:text-slate-500 transition-colors" lang="bn">{{ $fq->prompt_bn }}</p>
                                    @endif
                                </div>
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-transparent group-hover:ring-slate-300 transition-all pointer-events-none"></div>
                            </label>
                        @endforeach
                    </div>
                    
                    @if($filterQuestions->isEmpty())
                        <div class="flex flex-col items-center justify-center py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <svg class="h-8 w-8 text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                            <p class="text-[13px] font-semibold text-slate-500">{{ __('No filterable questions available') }}</p>
                            <p class="text-[11px] text-slate-400 mt-1 max-w-[240px]">{{ __('Ensure you have questions of type "Selection" or "Boolean" created first.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="submit" class="group relative flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-8 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition-all hover:bg-black hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="h-4 w-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
    </div>
@endsection
