@extends('layouts.admin')

@section('title', __('Admin Dashboard'))
@section('heading', __('Dashboard Overview'))
@section('subheading', __('Real-time insights and complaint activity metrics.'))

@section('content')

    {{-- ═══════════════════════════════════════════════════════════
         ALL-TIME STATS ROW
    ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">

        {{-- Total Submissions --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Total Complaints') }}</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ number_format($totalComplaints) }}</p>
                </div>
            </div>
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-indigo-50 blur-xl"></div>
        </div>

        {{-- Today's Complaints --}}
        <div class="relative overflow-hidden rounded-2xl border border-violet-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </span>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __("Today's Complaints") }}</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ number_format($todayTotal) }}</p>
                    <p class="mt-0.5 flex items-center gap-1 text-xs text-violet-500 font-semibold">
                        <span class="relative flex h-1.5 w-1.5"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-violet-400 opacity-75"></span><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-violet-500"></span></span>
                        {{ now()->format('M j, Y') }}
                    </p>
                </div>
            </div>
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-violet-50 blur-xl"></div>
        </div>

        {{-- Active/In Progress --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Active Complaints') }}</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ number_format($activeCount) }}</p>
                </div>
            </div>
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-amber-50 blur-xl"></div>
        </div>

        {{-- Resolution Rate --}}
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div class="w-full">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Resolution Rate') }}</p>
                    <div class="flex items-center justify-between mt-1 w-full">
                        <p class="text-3xl font-extrabold text-slate-900">{{ $resolutionRate }}%</p>
                        <div class="w-1/2 ml-4">
                            <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500 transition-all duration-700" style="width: {{ $resolutionRate }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-emerald-50 blur-xl"></div>
        </div>
    </div>



    {{-- ═══════════════════════════════════════════════════════════
         MAIN 2-COL GRID: Charts (left) + Recent Complaints (right)
    ═══════════════════════════════════════════════════════════ --}}
    <div class="grid gap-6 lg:grid-cols-[1fr_380px]">

        {{-- LEFT: Charts --}}
        <div class="space-y-6">

            {{-- Day-wise bar chart (30 days) --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                        </span>
                        <h2 class="text-sm font-bold text-slate-900">{{ __('Daily Complaints') }}</h2>
                    </div>
                    <span class="text-xs text-slate-400 font-medium">{{ __('Last 30 days') }}</span>
                </div>
                <div class="p-6">
                    <div class="relative h-52">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Doughnut: status breakdown --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
                        </span>
                        <h2 class="text-sm font-bold text-slate-900">{{ __('Complaints by Status') }}</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Recent Complaints --}}
        <div>
        <div class="flex flex-col h-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all hover:shadow-md">
            <div class="shrink-0 flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-slate-50/80 to-white px-5 py-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-sky-50 text-sky-600 shadow-sm ring-1 ring-sky-500/10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-800">{{ __('Recent Complaints') }}</h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ __('Feed activity') }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.complaints.index') }}"
                    class="group flex items-center gap-1 text-[11px] font-bold text-indigo-600 transition-all hover:text-indigo-800">
                    {{ __('View all') }}
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar">
                    @forelse($recentComplaints as $c)
                        @php
                            $sc = $c->status->colorClasses();
                            $isToday = $c->created_at->isToday();
                            
                            // Find name
                            $nameAnswer = $c->answers()->whereHas('question', fn($q) => $q->where('prompt', 'LIKE', '%Name%'))->first();
                            $nameValue = $nameAnswer ? json_decode($nameAnswer->value, true) : null;
                            $name = is_array($nameValue) ? implode(', ', $nameValue) : ($nameAnswer->value ?? __('Anonymous'));

                            // Find subject specifically
                            $subjectAnswer = $c->answers()->whereHas('question', fn($q) => $q->where('prompt', 'LIKE', '%subject%'))->first();

                            // Fallback preview
                            $previewAnswer = $subjectAnswer ?: $c->answers()->whereHas('question', function($q) {
                                $q->where('type', '!=', \App\Models\ComplaintQuestion::TYPE_FILE)
                                  ->where('prompt', 'NOT LIKE', '%Name%')
                                  ->where('prompt', 'NOT LIKE', '%email%');
                            })->first();

                            $previewText = $previewAnswer ? json_decode($previewAnswer->value, true) : null;
                            if (is_array($previewText)) $previewText = implode(', ', $previewText);
                            else $previewText = $previewAnswer->value ?? '';
                        @endphp
                        <a href="{{ route('admin.complaints.show', $c) }}"
                            class="group relative flex flex-col rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                            
                            {{-- User row --}}
                            <div class="flex items-center gap-3 mb-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 font-bold text-slate-500 text-xs uppercase shadow-sm transition-colors">
                                    {{ mb_substr($name, 0, 1) }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-extrabold text-slate-800 truncate transition-colors">{{ $name }}</h4>
                                    <span class="inline-flex items-center gap-1 font-mono text-[10px] font-bold text-slate-400">
                                        #{{ $c->public_reference }}
                                    </span>
                                </div>
                                <span class="shrink-0 text-[10px] font-bold text-slate-400">
                                    {{ $isToday ? $c->created_at->diffForHumans() : $c->created_at->format('M j') }}
                                </span>
                            </div>

                            {{-- Preview area --}}
                            @if($previewText)
                            <div class="bg-slate-50/50 rounded-xl p-2.5 mb-3 border border-slate-100/50 transition-all">
                                <p class="text-[12px] font-medium text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($previewText, 80) }}
                                </p>
                            </div>
                            @endif

                            {{-- Final Footer row --}}
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-[10px] font-bold ring-1 ring-inset" style="{{ $sc['badge_style'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full animate-pulse" style="{{ $sc['dot_style'] }}"></span>
                                    {{ $c->status->alias_name }}
                                </span>
                                <span class="text-[10px] font-bold text-indigo-400 flex items-center gap-0.5 transition-colors">
                                    {{ __('View Action') }}
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </span>
                            </div>

                        </a>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-4">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-600">{{ __('No complaints yet') }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ __('Submitted complaints will appear here.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Shared helpers ───────────────────────────────────────── */
    function hexToRgba(hex, alpha) {
        if (!hex || !hex.startsWith('#')) hex = '#94a3b8';
        if (hex.length === 4) hex = '#' + hex[1] + hex[1] + hex[2] + hex[2] + hex[3] + hex[3];
        const r = parseInt(hex.slice(1, 3), 16),
              g = parseInt(hex.slice(3, 5), 16),
              b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    const fontFamily = "'Plus Jakarta Sans', sans-serif";

    /* ── 1. Day-wise bar chart ────────────────────────────────── */
    const dailyLabels = @json($dailyLabels);
    const dailyData   = @json($dailyData);

    const dailyCtx = document.getElementById('dailyChart').getContext('2d');

    // Gradient fill
    const grad = dailyCtx.createLinearGradient(0, 0, 0, 200);
    grad.addColorStop(0, 'rgba(99, 102, 241, 0.85)');
    grad.addColorStop(1, 'rgba(139, 92, 246, 0.55)');

    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Complaints',
                data: dailyData,
                backgroundColor: grad,
                borderColor: 'rgba(99, 102, 241, 0.9)',
                borderWidth: 0,
                borderRadius: 6,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(99, 102, 241, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: fontFamily, size: 11 },
                    bodyFont:  { family: fontFamily, size: 12, weight: 'bold' },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        title: (items) => items[0].label,
                        label: (item)  => ` ${item.raw} complaint${item.raw !== 1 ? 's' : ''}`,
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: fontFamily, size: 10 },
                        color: '#94a3b8',
                        maxRotation: 45,
                        // Show every ~5th label to avoid crowding
                        callback: function (val, idx) {
                            return idx % 5 === 0 ? this.getLabelForValue(val) : '';
                        }
                    },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.12)' },
                    ticks: {
                        font: { family: fontFamily, size: 11 },
                        color: '#94a3b8',
                        precision: 0,
                    },
                    border: { display: false }
                }
            }
        }
    });

    /* ── 2. Doughnut: status breakdown ───────────────────────── */
    const rawData     = @json($statusCounts);
    const labels      = rawData.map(i => i.alias_name);
    const data        = rawData.map(i => i.count);
    const bgColors    = rawData.map(i => hexToRgba(i.color, 0.82));
    const borderColors = rawData.map(i => i.color || '#64748b');
    const total       = data.reduce((a, b) => a + b, 0);

    const statusCtx = document.getElementById('statusChart').getContext('2d');

    if (total === 0) {
        statusCtx.font = `14px ${fontFamily}`;
        statusCtx.fillStyle = '#94a3b8';
        statusCtx.textAlign = 'center';
        statusCtx.fillText('No data available', statusCtx.canvas.width / 2, statusCtx.canvas.height / 2);
        return;
    }

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor: bgColors,
                borderColor: borderColors,
                borderWidth: 2,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { family: fontFamily, size: 12 },
                        usePointStyle: true,
                        padding: 18,
                        generateLabels: (chart) => {
                            const ds    = chart.data.datasets[0];
                            const total = ds.data.reduce((a, b) => a + b, 0);
                            return chart.data.labels.map((label, i) => ({
                                text: `${label}  (${ds.data[i]})`,
                                fillStyle: ds.backgroundColor[i],
                                strokeStyle: ds.borderColor[i],
                                lineWidth: 2,
                                hidden: false,
                                index: i,
                                pointStyle: 'circle',
                            }));
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: fontFamily },
                    bodyFont:  { family: fontFamily },
                    padding: 12,
                    cornerRadius: 8,
                    boxPadding: 6,
                    callbacks: {
                        label: (item) => {
                            const pct = total > 0 ? Math.round((item.raw / total) * 100) : 0;
                            return `  ${item.raw} complaint${item.raw !== 1 ? 's' : ''} (${pct}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
