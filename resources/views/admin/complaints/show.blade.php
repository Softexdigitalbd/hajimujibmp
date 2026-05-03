@extends('layouts.admin')

@section('title', $complaint->public_reference)
@section('heading', __('Complaint').' '.$complaint->public_reference)
@section('subheading', __('Review answers, update status, and add internal notes.'))

@section('content')

@php
$fileAnswers = $complaint->answers->filter(fn($a) => $a->question->type === \App\Models\ComplaintQuestion::TYPE_FILE);
$textAnswers = $complaint->answers->filter(fn($a) => $a->question->type !== \App\Models\ComplaintQuestion::TYPE_FILE);
$imageExts = ['jpg','jpeg','png','webp','gif'];
$isImageExt = fn(string $ext): bool => in_array(strtolower($ext), $imageExts);
$statusColors = $complaint->status->colorClasses();
@endphp

{{-- ── Top bar ── --}}
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <a href="{{ route('admin.complaints.index') }}"
        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-500 shadow-sm transition-all hover:border-slate-300 hover:text-slate-900 hover:shadow-md">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        {{ __('Back to list') }}
    </a>

    {{-- Inline status action buttons --}}
    <div class="flex flex-wrap items-center gap-2">
        @if(auth()->user()->hasPermission('complaints.update_status') && $allowedTransitions->isNotEmpty())
        @foreach($allowedTransitions as $st)
        @php $tc = $st->colorClasses(); @endphp
        <form method="POST" action="{{ route('admin.complaints.update-status', $complaint) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="complaint_status_id" value="{{ $st->id }}">
            <button type="submit"
                class="inline-flex items-center rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1"
                style="{{ $tc['button_style'] ?? '' }}">
                {{ $st->alias_name }}
            </button>
        </form>
        @endforeach
        @else
        <span class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 text-xs font-bold ring-1 ring-inset"
            style="{{ $statusColors['badge_style'] }}">
            <span class="h-1.5 w-1.5 animate-pulse rounded-full" style="{{ $statusColors['dot_style'] }}"></span>
            {{ $complaint->status->alias_name }}
        </span>
        @endif
    </div>
</div>


{{-- ── 2-column grid: details+activity | sidebar ── --}}
<div class="grid gap-6 lg:grid-cols-[1fr_300px] xl:grid-cols-[1fr_320px]">

    {{-- ════════════════════════════
    LEFT — Details + Activity
    ════════════════════════════ --}}
    <div class="space-y-6">

        {{-- Complaint Details --}}
        <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-3 flex items-center gap-3">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-sm font-bold text-slate-900">{{ __('Complaint Details') }}</h2>
                </div>
            </div>

            <dl class="divide-y divide-slate-50/80">

                {{-- Dynamic text answers --}}
                @foreach($textAnswers as $answer)
                @php
                $q = $answer->question;
                $decoded = json_decode($answer->value, true);
                if ($q->type === \App\Models\ComplaintQuestion::TYPE_BOOLEAN) {
                $display = $answer->value === '1' ? __('Yes') : __('No');
                } elseif ($q->type === \App\Models\ComplaintQuestion::TYPE_SELECTION && is_array($decoded)) {
                $display = implode(', ', $decoded);
                } else {
                $display = is_array($decoded) ? implode(', ', $decoded) : $answer->value;
                }
                $isLong = mb_strlen($display ?? '') > 80 || $q->type === \App\Models\ComplaintQuestion::TYPE_TEXTAREA;
                @endphp
                <div
                    class="{{ $isLong ? 'flex flex-col gap-1.5' : 'grid grid-cols-[160px_1fr] gap-4' }} px-5 py-3 hover:bg-slate-50/40 transition">
                    <dt class="flex items-start text-[13px] font-semibold text-slate-500">
                        <span>
                            {{ $q->prompt }}
                            @if(filled($q->prompt_bn))
                            <span class="block text-[11px] font-normal text-slate-400 noto-bn" lang="bn">{{
                                $q->prompt_bn }}</span>
                            @endif
                        </span>
                    </dt>
                    <dd class="text-[13px] font-medium text-slate-900 leading-relaxed whitespace-pre-wrap">{{ $display ?:
                        '—' }}</dd>
                </div>
                @endforeach

                {{-- File / image answers (only shown with download permission) --}}
                @if(auth()->user()->hasPermission('complaints.download'))
                @foreach($fileAnswers as $answer)
                @php
                $q = $answer->question;
                $decoded = json_decode($answer->value, true);
                $decoded = is_array($decoded) ? $decoded : [];
                // Normalise: single object {path,original} → wrap in array; already an indexed array → use as-is
                $files = isset($decoded['path']) ? [$decoded] : array_values($decoded);
                $files = array_filter($files, fn($f) => !empty($f['path']));
                $hasFile = !empty($files);
                // Keep first-file vars for the download route (route only serves first file)
                $meta = $hasFile ? $files[0] : [];
                $ext = $hasFile ? strtolower(pathinfo($meta['original'] ?? '', PATHINFO_EXTENSION)) : '';
                $isImg = $hasFile && $isImageExt($ext);
                $inlineUrl = $hasFile ? route('admin.complaints.answers.file.inline', [$complaint, $answer]) : null;
                $downloadUrl = $hasFile ? route('admin.complaints.answers.file', [$complaint, $answer]) : null;
                @endphp
                <div class="flex flex-col gap-2.5 px-5 py-4 hover:bg-slate-50/40 transition">
                    <dt class="flex items-center text-[13px] font-semibold text-slate-500">
                        <span>
                            {{ $q->prompt }}
                            @if(filled($q->prompt_bn))
                            <span class="block text-[11px] font-normal text-slate-400 noto-bn" lang="bn">{{
                                $q->prompt_bn }}</span>
                            @endif
                        </span>
                    </dt>
                    <dd>
                        @if($hasFile)
                        @if($isImg)
                        <a href="{{ $downloadUrl }}" target="_blank"
                            class="group block overflow-hidden rounded-xl border border-slate-200/60 shadow-sm transition-all hover:border-emerald-300 hover:shadow-md"
                            style="max-width: 320px;">
                            <img src="{{ $inlineUrl }}" alt="{{ $meta['original'] ?? __('Uploaded image') }}"
                                class="w-full object-cover" style="max-height: 200px;">
                            <div
                                class="flex items-center gap-2 border-t border-slate-100 bg-slate-50 px-4 py-2.5 group-hover:bg-emerald-50 transition">
                                <svg class="h-3.5 w-3.5 shrink-0 text-slate-400 group-hover:text-emerald-600"
                                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                <span
                                    class="truncate text-xs font-semibold text-slate-600 group-hover:text-emerald-800">{{
                                    $meta['original'] ?? __('Download image') }}</span>
                            </div>
                        </a>
                        @else
                        <a href="{{ $downloadUrl }}"
                            class="group inline-flex items-center gap-3 rounded-xl border border-slate-200/60 bg-slate-50 px-4 py-3 transition-all hover:border-sky-300 hover:bg-sky-50/60 hover:shadow-md"
                            style="max-width: 360px;">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 transition group-hover:bg-sky-200">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-700 group-hover:text-sky-800">{{
                                    $meta['original'] ?? __('Download file') }}</p>
                                <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-400">{{
                                    strtoupper($ext) ?: __('File') }}</p>
                            </div>
                            <svg class="ml-auto h-4 w-4 shrink-0 text-slate-300 group-hover:text-sky-500 transition"
                                fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </a>
                        @endif
                        @else
                        <div
                            class="inline-flex items-center gap-2 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-3">
                            <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                            </svg>
                            <p class="text-sm text-slate-400 italic">{{ __('No file uploaded') }}</p>
                        </div>
                        @endif
                    </dd>
                </div>
                @endforeach
                @endif

            </dl>
        </div>

        {{-- Activity Log --}}
        <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
                <div class="flex items-center gap-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <h2 class="text-sm font-bold text-slate-900">{{ __('Activity Log') }}</h2>
                </div>
                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-500">
                    {{ $complaint->auditLogs->count() }}
                </span>
            </div>

            @if($complaint->auditLogs->isEmpty())
            <div class="flex flex-col items-center justify-center gap-3 py-14 text-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <p class="text-sm font-medium text-slate-500">{{ __('No activity yet') }}</p>
            </div>
            @else
            <div class="px-5 py-4">
                <ol class="space-y-0">
                    @foreach($complaint->auditLogs->reverse() as $log)
                    @php
                    $isStatus = $log->action === \App\Models\AuditLog::ACTION_STATUS_CHANGED;
                    $hasAttach = !$isStatus && $log->comment?->attachment_path;
                    $attachExt = $hasAttach ? strtolower(pathinfo($log->comment->original_filename ?? '',
                    PATHINFO_EXTENSION)) : '';
                    $attachIsImage = $hasAttach && $isImageExt($attachExt);
                    @endphp
                    <li class="relative flex gap-4 {{ $loop->last ? '' : 'pb-7' }}">
                        @unless($loop->last)
                        <div class="absolute left-4 top-8 bottom-0 w-px bg-gradient-to-b from-slate-200 to-slate-100"
                            aria-hidden="true"></div>
                        @endunless

                        <div
                            class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full ring-4 ring-white
                                    {{ $isStatus ? 'bg-emerald-100 text-emerald-700' : 'bg-violet-100 text-violet-700' }}">
                            @if($isStatus)
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                            @else
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0 pt-0.5">
                            <div class="flex flex-wrap items-baseline gap-x-2 gap-y-0.5">
                                <span class="text-sm font-bold text-slate-900">
                                    {{ $log->user?->name ?? ($isStatus ? __('System') : __('Admin')) }}
                                </span>
                                <span class="text-xs text-slate-400">{{ $log->created_at->format('M j, Y · H:i')
                                    }}</span>
                            </div>

                            @if($isStatus)
                            @php $toC = $log->toStatus?->colorClasses() ?? []; @endphp
                            <p class="mt-1 text-sm text-slate-600">
                                {{ __('Changed status') }}
                                @if($log->fromStatus)
                                {{ __('from') }}
                                @php $fromC = $log->fromStatus->colorClasses(); @endphp
                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset"
                                    style="{{ $fromC['badge_style'] ?? '' }}">
                                    {{ $log->fromStatus->alias_name }}
                                </span>
                                @endif
                                @if($log->toStatus)
                                {{ $log->fromStatus ? __('to') : __('set to') }}
                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-bold ring-1 ring-inset"
                                    style="{{ $toC['badge_style'] ?? '' }}">
                                    {{ $log->toStatus->alias_name }}
                                </span>
                                @endif
                            </p>
                            @else
                            <div
                                class="mt-2 rounded-xl border border-slate-100 bg-slate-50/80 px-4 py-3 text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">
                                {{ $log->comment?->body }}</div>

                            @if($hasAttach && auth()->user()->hasPermission('complaints.download'))
                            @if($attachIsImage)
                            <div class="mt-2 overflow-hidden rounded-xl border border-slate-200/60 shadow-sm"
                                style="max-width: 360px;">
                                <img src="{{ route('admin.complaints.comments.attachment.inline', [$complaint, $log->comment]) }}"
                                    alt="{{ $log->comment->original_filename ?? __('Attachment') }}"
                                    class="w-full object-cover" style="max-height: 220px;">
                                <div
                                    class="flex items-center justify-between gap-2 border-t border-slate-100 bg-slate-50 px-3 py-2">
                                    <span class="truncate text-xs text-slate-500">{{ $log->comment->original_filename ??
                                        __('Image') }}</span>
                                    <a href="{{ route('admin.complaints.comments.attachment', [$complaint, $log->comment]) }}"
                                        class="inline-flex shrink-0 items-center gap-1 rounded-md border border-slate-200 bg-white px-2 py-1 text-[11px] font-semibold text-slate-600 shadow-sm transition hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        {{ __('Download') }}
                                    </a>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('admin.complaints.comments.attachment', [$complaint, $log->comment]) }}"
                                class="mt-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-700">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                {{ $log->comment->original_filename ?? __('Download attachment') }}
                            </a>
                            @endif
                            @endif
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
            @endif
        </div>
    </div>

    {{-- ════════════════════════════
    RIGHT — Actions sidebar
    ════════════════════════════ --}}
    <div class="space-y-5">

        {{-- Summary --}}
        <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white px-4 py-2.5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ __('Summary') }}</p>
            </div>
            <dl class="divide-y divide-slate-50">
                <div class="flex items-center justify-between px-4 py-2.5">
                    <dt class="text-[11px] text-slate-500">{{ __('Complaint No.') }}</dt>
                    <dd class="font-mono text-[10px] font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-md">{{
                        $complaint->public_reference }}</dd>
                </div>
                <div class="flex items-center justify-between px-4 py-2.5">
                    <dt class="text-[11px] text-slate-500">{{ __('Submitted') }}</dt>
                    <dd class="text-[11px] font-medium text-slate-700">{{ $complaint->created_at->format('M j, Y') }}</dd>
                </div>
                <div class="flex items-center justify-between px-4 py-2.5">
                    <dt class="text-[11px] text-slate-500">{{ __('Status') }}</dt>
                    <dd>
                        <span
                            class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold ring-1 ring-inset"
                            style="{{ $statusColors['badge_style'] ?? '' }}">
                            <span class="h-1.5 w-1.5 animate-pulse rounded-full"
                                style="{{ $statusColors['dot_style'] ?? '' }}"></span>
                            {{ $complaint->status->alias_name }}
                        </span>
                    </dd>
                </div>
                <div class="flex items-center justify-between px-4 py-2.5">
                    <dt class="text-[11px] text-slate-500">{{ __('State') }}</dt>
                    <dd class="text-[11px] font-semibold text-slate-700">{{ $complaint->status->state }}</dd>
                </div>
                <div class="flex items-center justify-between px-4 py-2.5">
                    <dt class="text-[11px] text-slate-500">{{ __('Activity') }}</dt>
                    <dd class="text-[11px] font-semibold text-slate-700">
                        {{ $complaint->auditLogs->count() }} {{ Str::plural('entry', $complaint->auditLogs->count()) }}
                    </dd>
                </div>
            </dl>
        </div>



        {{-- Add a Note (only for users with comment permission) --}}
        @if(auth()->user()->hasPermission('complaints.comment'))
        <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white px-4 py-2.5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ __('Add a Note') }}</p>
                <p class="mt-0.5 text-[10px] text-slate-400">{{ __('Visible in the activity log.') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.complaints.comments.store', $complaint) }}"
                enctype="multipart/form-data" class="p-4 space-y-3">
                @csrf
                <textarea id="body" name="body" rows="4" required
                    placeholder="{{ __('Write your internal note here…') }}"
                    class="w-full resize-none rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition">{{ old('body') }}</textarea>

                <label
                    class="flex cursor-pointer items-center gap-3 rounded-xl border border-dashed border border-slate-200 bg-white px-4 py-3 transition-all hover:border-violet-300 hover:bg-violet-50/20">
                    <svg class="h-5 w-5 shrink-0 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                    </svg>
                    <span id="file-name-label" class="flex-1 truncate text-xs text-slate-500">
                        {{ __('Attach a file') }} <span class="text-slate-400">({{ __('optional') }})</span>
                    </span>
                    <input type="file" name="attachment" class="sr-only"
                        onchange="document.getElementById('file-name-label').textContent = this.files[0]?.name || '{{ __('Attach a file') }}'">
                </label>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition-all hover:bg-emerald-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:ring-offset-1">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                    {{ __('Save note') }}
                </button>
            </form>
        </div>
        @endif
    </div>

</div>
@endsection