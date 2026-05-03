@extends('layouts.admin')

@section('title', __('System Trash'))
@section('heading', __('System Trash'))
@section('subheading', __('Recover previously deleted statuses and questions or view discovery records.'))

@section('content')
<div class="mb-8 flex flex-wrap items-center justify-between gap-4">
    <a href="{{ route('admin.settings.statuses.index') }}"
        class="inline-flex items-center gap-2 rounded-xl bg-white border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        {{ __('Back to settings') }}
    </a>
</div>

<div class="space-y-12">
    {{-- Trashed Statuses Section --}}
    <div>
        <div class="mb-5 flex items-center gap-3">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-widest">{{ __('Trashed Statuses') }}
            </h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr
                        class="bg-slate-50/90 border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4">{{ __('Label') }}</th>
                        <th class="px-6 py-4">{{ __('State') }}</th>
                        <th class="px-6 py-4">{{ __('Deleted At') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($statuses as $st)
                    <tr class="hover:bg-slate-50/30 transition text-slate-700">
                        <td class="px-6 py-4 font-medium">
                            @php $sc = $st->colorClasses(); @endphp
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset"
                                style="{{ $sc['badge_style'] }}">
                                <span class="h-1.5 w-1.5 rounded-full" style="{{ $sc['dot_style'] }}"></span>
                                {{ $st->alias_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-600 ring-1 ring-slate-200/50">{{
                                $st->state }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                            {{ $st->deleted_at->format('M j, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.settings.statuses.restore', $st->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="inline-flex h-8 items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 text-xs font-bold text-indigo-700 shadow-sm transition hover:bg-indigo-100 hover:border-indigo-300">
                                    <svg class="h-3 w-3 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    {{ __('Restore') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center">
                            <p class="text-xs font-bold text-slate-400">{{ __('No trashed statuses found') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Trashed Questions Section --}}
    <div>
        <div class="mb-5 flex items-center gap-3">
            <span
                class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600 ring-1 ring-sky-500/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
            </span>
            <h3 class="text-[13px] font-extrabold text-slate-800 uppercase tracking-widest">{{ __('Trashed Questions')
                }}</h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead>
                    <tr
                        class="bg-slate-50/90 border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4">{{ __('Question Prompt') }}</th>
                        <th class="px-6 py-4">{{ __('Type') }}</th>
                        <th class="px-6 py-4">{{ __('Deleted At') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($questions as $q)
                    <tr class="hover:bg-slate-50/30 transition text-slate-700">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 line-clamp-1">{{ $q->prompt }}</p>
                            @if($q->prompt_bn)
                            <p class="text-[11px] font-medium text-slate-400 mt-0.5 noto-bn">{{ $q->prompt_bn }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex rounded-full px-2 py-0.5 text-[11px] font-bold bg-slate-100 text-slate-500 ring-1 ring-slate-200/50 uppercase tracking-tighter">{{
                                $q->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                            {{ $q->deleted_at->format('M j, Y h:i A') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.settings.questions.restore', $q->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="inline-flex h-8 items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 text-xs font-bold text-indigo-700 shadow-sm transition hover:bg-indigo-100 hover:border-indigo-300">
                                    <svg class="h-3 w-3 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    {{ __('Restore') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center">
                            <p class="text-xs font-bold text-slate-400">{{ __('No trashed questions found') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection