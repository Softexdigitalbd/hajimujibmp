<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-indigo-600 mb-1">{{ __('Overview') }}</p>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">{{ __('Dashboard') }}</h1>
        </div>
        <a href="{{ route('complaint.create') }}"
           class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            {{ __('Submit complaint') }}
        </a>
    </x-slot>

    <div class="space-y-6 pb-12">

        {{-- ═══════════════════════════════════════════
             WELCOME BANNER — Full-width gradient hero
        ═══════════════════════════════════════════ --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 px-7 py-7 sm:px-10 sm:py-9">
            {{-- Decorative shapes --}}
            <div class="pointer-events-none absolute -right-8 -top-8 h-48 w-48 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-indigo-400/20 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute right-1/4 top-0 h-24 w-24 rounded-full bg-violet-400/15 blur-2xl" aria-hidden="true"></div>
            {{-- Subtle pattern --}}
            <div class="pointer-events-none absolute inset-0 opacity-[0.05]" aria-hidden="true"
                 style="background-image: radial-gradient(rgba(255,255,255,1) 1px,transparent 1px); background-size: 20px 20px;"></div>

            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-5">
                    {{-- Avatar --}}
                    <div class="relative shrink-0">
                        <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 text-2xl font-extrabold text-white shadow-lg shadow-black/10 ring-4 ring-white/15 uppercase select-none backdrop-blur-sm">
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        </span>
                        <span class="absolute -bottom-0.5 -right-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-400 ring-2 ring-indigo-600">
                            <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </span>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold tracking-tight text-white sm:text-2xl">
                            {{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}
                        </h2>
                        <p class="mt-1 text-sm text-indigo-100/80">
                            {{ __("You're signed in and ready to go. Manage your account or explore the site.") }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-white/15 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-white/20 backdrop-blur-sm transition-all hover:bg-white/25 hover:ring-white/30">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        {{ __('Visit site') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════
             STAT CARDS — Colorful gradient backgrounds
        ═══════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @php
                $stats = [
                    [
                        'label' => __('Account'),
                        'value' => __('Active'),
                        'sub'   => __('Fully operational'),
                        'from'  => 'from-emerald-500',
                        'to'    => 'to-teal-600',
                        'shadow'=> 'shadow-emerald-500/30',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    ],
                    [
                        'label' => __('Email'),
                        'value' => __('Verified'),
                        'sub'   => Auth::user()->email,
                        'from'  => 'from-blue-500',
                        'to'    => 'to-cyan-600',
                        'shadow'=> 'shadow-blue-500/30',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>',
                    ],
                    [
                        'label' => __('Role'),
                        'value' => __('Member'),
                        'sub'   => __('Standard access'),
                        'from'  => 'from-violet-500',
                        'to'    => 'to-purple-600',
                        'shadow'=> 'shadow-violet-500/30',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>',
                    ],
                    [
                        'label' => __('Member since'),
                        'value' => Auth::user()->created_at->format('M Y'),
                        'sub'   => Auth::user()->created_at->diffForHumans(),
                        'from'  => 'from-amber-500',
                        'to'    => 'to-orange-600',
                        'shadow'=> 'shadow-amber-500/30',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>',
                    ],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $stat['from'] }} {{ $stat['to'] }} p-5 shadow-lg {{ $stat['shadow'] }} transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-default">
                    {{-- Large ghost icon --}}
                    <div class="pointer-events-none absolute -right-3 -bottom-3 opacity-[0.15]" aria-hidden="true">
                        <svg class="h-24 w-24" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            {!! $stat['icon'] !!}
                        </svg>
                    </div>
                    <div class="relative">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-white/70">{{ $stat['label'] }}</p>
                        <p class="mt-1 text-xl font-extrabold text-white sm:text-2xl">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-xs text-white/60 truncate">{{ $stat['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ═══════════════════════════════════════════
             MAIN CONTENT — 2-column layout
        ═══════════════════════════════════════════ --}}
        <div class="grid gap-6 lg:grid-cols-[1fr_340px]">

            {{-- LEFT COLUMN — Quick actions --}}
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <h3 class="text-sm font-bold text-slate-900">{{ __('Quick actions') }}</h3>
                    <div class="h-px flex-1 bg-gradient-to-r from-slate-200 to-transparent"></div>
                </div>

                {{-- Action card grid --}}
                <div class="grid grid-cols-2 gap-4">
                    {{-- Submit complaint --}}
                    <a href="{{ route('complaint.create') }}"
                       class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-indigo-200">
                        <div class="pointer-events-none absolute -right-6 -bottom-6 h-28 w-28 rounded-full bg-indigo-50 opacity-0 blur-2xl transition-opacity duration-500 group-hover:opacity-100" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/25 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </span>
                            <h4 class="mt-4 text-sm font-bold text-slate-900">{{ __('New complaint') }}</h4>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">{{ __('Submit a new complaint through the public form.') }}</p>
                            <span class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-indigo-600 group-hover:text-indigo-700">
                                {{ __('Start') }}
                                <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Edit profile --}}
                    <a href="{{ route('profile.edit') }}"
                       class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-emerald-200">
                        <div class="pointer-events-none absolute -right-6 -bottom-6 h-28 w-28 rounded-full bg-emerald-50 opacity-0 blur-2xl transition-opacity duration-500 group-hover:opacity-100" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/25 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </span>
                            <h4 class="mt-4 text-sm font-bold text-slate-900">{{ __('Edit profile') }}</h4>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">{{ __('Update display name, email, or password.') }}</p>
                            <span class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-emerald-600 group-hover:text-emerald-700">
                                {{ __('Manage') }}
                                <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Visit public site --}}
                    <a href="{{ route('home') }}"
                       class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-sky-200">
                        <div class="pointer-events-none absolute -right-6 -bottom-6 h-28 w-28 rounded-full bg-sky-50 opacity-0 blur-2xl transition-opacity duration-500 group-hover:opacity-100" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white shadow-lg shadow-sky-500/25 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12c0 .778.099 1.533.284 2.253"/></svg>
                            </span>
                            <h4 class="mt-4 text-sm font-bold text-slate-900">{{ __('Public site') }}</h4>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">{{ __('Browse the public homepage.') }}</p>
                            <span class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-sky-600 group-hover:text-sky-700">
                                {{ __('Visit') }}
                                <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Account settings --}}
                    <a href="{{ route('profile.edit') }}"
                       class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-5 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:border-amber-200">
                        <div class="pointer-events-none absolute -right-6 -bottom-6 h-28 w-28 rounded-full bg-amber-50 opacity-0 blur-2xl transition-opacity duration-500 group-hover:opacity-100" aria-hidden="true"></div>
                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-lg shadow-amber-500/25 transition-transform duration-300 group-hover:scale-110">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <h4 class="mt-4 text-sm font-bold text-slate-900">{{ __('Account settings') }}</h4>
                            <p class="mt-1 text-xs text-slate-500 leading-relaxed">{{ __('Security and password settings.') }}</p>
                            <span class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-amber-600 group-hover:text-amber-700">
                                {{ __('Configure') }}
                                <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- RIGHT COLUMN — Profile card + Account details --}}
            <div class="space-y-6">

                {{-- Profile summary card --}}
                <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 px-6 py-6 text-center relative overflow-hidden">
                        {{-- Pattern overlay --}}
                        <div class="pointer-events-none absolute inset-0 opacity-[0.06]" aria-hidden="true"
                             style="background-image: radial-gradient(rgba(255,255,255,1) 1px,transparent 1px); background-size: 16px 16px;"></div>
                        <div class="relative">
                            <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 text-2xl font-extrabold text-white shadow-lg shadow-black/10 ring-4 ring-white/20 uppercase backdrop-blur-sm">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </span>
                            <h4 class="mt-3 text-base font-bold text-white">{{ Auth::user()->name }}</h4>
                            <p class="text-sm text-indigo-200">{{ __('Member') }}</p>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        {{-- Info rows --}}
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ __('Email') }}</p>
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ __('Joined') }}</p>
                                <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>

                        {{-- Profile completion --}}
                        <div class="pt-2">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-bold text-slate-700">{{ __('Profile completion') }}</p>
                                <span class="text-xs font-bold text-emerald-600">{{ __('85%') }}</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-1000" style="width: 85%"></div>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="mt-2 flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-indigo-300 hover:text-indigo-700 hover:shadow-md">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            {{ __('Edit profile') }}
                        </a>
                    </div>
                </div>

                {{-- Activity snapshot --}}
                <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            <p class="text-sm font-bold text-slate-900">{{ __('Activity') }}</p>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        @php
                            $activities = [
                                ['icon' => 'emerald', 'iconPath' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => __('Account created'), 'time' => Auth::user()->created_at->format('M j, Y')],
                                ['icon' => 'blue',    'iconPath' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75', 'text' => __('Email verified'), 'time' => __('Confirmed')],
                                ['icon' => 'indigo',  'iconPath' => 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75', 'text' => __('Last login'), 'time' => __('Just now')],
                            ];
                            $activityColors = [
                                'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                                'blue'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600'],
                                'indigo'  => ['bg' => 'bg-indigo-50',  'text' => 'text-indigo-600'],
                            ];
                        @endphp
                        @foreach($activities as $act)
                            @php $ac = $activityColors[$act['icon']]; @endphp
                            <div class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-slate-50/80">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $ac['bg'] }} {{ $ac['text'] }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $act['iconPath'] }}"/></svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold text-slate-800">{{ $act['text'] }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $act['time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════
             ACCOUNT DETAILS — Bottom table card
        ═══════════════════════════════════════════ --}}
        <div class="rounded-2xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-gradient-to-r from-slate-50/80 to-white">
                <div class="flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                    </span>
                    <h3 class="text-sm font-bold text-slate-900">{{ __('Account details') }}</h3>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="rounded-lg px-3 py-1.5 text-xs font-bold text-indigo-600 transition hover:bg-indigo-50 hover:text-indigo-700">
                    {{ __('Edit') }} →
                </a>
            </div>
            <div class="divide-y divide-slate-100/80">
                @foreach ([
                    [__('Full name'),     Auth::user()->name,  'text-indigo-600', 'bg-indigo-50',  'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                    [__('Email address'), Auth::user()->email, 'text-blue-600',   'bg-blue-50',    'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
                    [__('Joined'),        Auth::user()->created_at->format('F j, Y'), 'text-violet-600', 'bg-violet-50', 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                    [__('Status'),        __('Active'), 'text-emerald-600', 'bg-emerald-50', 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ] as [$label, $value, $iconColor, $iconBg, $iconPath])
                    <div class="flex items-center gap-4 px-6 py-4 transition hover:bg-slate-50/50">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $iconBg }} {{ $iconColor }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}"/></svg>
                        </span>
                        <dt class="text-sm text-slate-500 shrink-0 min-w-[120px]">{{ $label }}</dt>
                        <dd class="text-sm font-semibold text-slate-900 text-right truncate flex-1">
                            @if($label === __('Status'))
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-emerald-500/20">
                                    <span class="relative flex h-1.5 w-1.5"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span></span>
                                    {{ $value }}
                                </span>
                            @else
                                {{ $value }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
