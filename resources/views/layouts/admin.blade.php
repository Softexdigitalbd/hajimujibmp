<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Admin')) — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|noto-sans-bengali:400,500&display=swap" rel="stylesheet" />
    @include('partials.vite-assets')
    <style>
        .admin-shell { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        .noto-bn { font-family: 'Noto Sans Bengali', 'Plus Jakarta Sans', system-ui, sans-serif; }

        /* Sidebar nav active indicator */
        .admin-nav-active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.12) 0%, rgba(99, 102, 241, 0.03) 100%);
            color: #fff;
            position: relative;
        }
        .admin-nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
        }

        /* Smooth sidebar transitions */
        .sidebar-link {
            position: relative;
            transition: all 0.2s ease;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.06); color: #fff; }

        /* Content entrance */
        .admin-content { animation: adminContentEnter 0.35s ease-out; }
        @keyframes adminContentEnter {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
    @stack('head')
</head>
<body class="admin-shell min-h-full bg-[#f0f2f7] text-slate-800 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-[260px] shrink-0 flex flex-col bg-gradient-to-b from-[#0f172a] via-[#111827] to-[#0f172a] text-slate-400 shadow-2xl shadow-slate-900/30">
            {{-- Brand --}}
            <div class="p-5 pb-4">
                <a href="{{ route('admin.dashboard') }}" class="block group">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/20 transition-transform duration-300 group-hover:scale-105">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.315 48.315 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/></svg>
                        </span>
                        <div>
                            <span class="text-sm font-bold tracking-tight text-white">{{ config('app.name') }}</span>
                            <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[0.2em] text-indigo-400/80">{{ __('Console') }}</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mx-4 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

            {{-- Navigation --}}
            <nav class="p-3 space-y-1 flex-1 overflow-y-auto text-[13px] font-medium mt-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/></svg>
                    {{ __('Dashboard') }}
                </a>

                @if(auth()->user()->hasPermission('complaints.index'))
                <a href="{{ route('admin.complaints.index') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.complaints.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    {{ __('Complaints') }}
                </a>
                @endif

                {{-- Settings Section --}}
                @if(auth()->user()->hasAnyPermission(['settings.behaviour','settings.statuses','settings.transitions','settings.questions','settings.trash']))
                <p class="px-3 pt-6 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-600">{{ __('Settings') }}</p>

                @if(auth()->user()->hasPermission('settings.behaviour'))
                <a href="{{ route('admin.settings.behaviour.edit') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.settings.behaviour.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    {{ __('Complaint Behaviour') }}
                </a>
                @endif
                @if(auth()->user()->hasPermission('settings.statuses'))
                <a href="{{ route('admin.settings.statuses.index') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.settings.statuses.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    {{ __('Complaint Status') }}
                </a>
                @endif
                @if(auth()->user()->hasPermission('settings.transitions'))
                <a href="{{ route('admin.settings.transitions.index') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.settings.transitions.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    {{ __('Status Transitions') }}
                </a>
                @endif
                @if(auth()->user()->hasPermission('settings.questions'))
                <a href="{{ route('admin.settings.questions.index') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.settings.questions.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('Form Questions') }}
                </a>
                @endif
                @endif

                {{-- Access Control --}}
                @if(auth()->user()->hasAnyPermission(['users.view','roles.view']))
                <p class="px-3 pt-6 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-600">{{ __('Access Control') }}</p>

                @if(auth()->user()->hasPermission('users.view'))
                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.users.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    {{ __('Users') }}
                </a>
                @endif

                @if(auth()->user()->hasPermission('roles.view'))
                <a href="{{ route('admin.roles.index') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.roles.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    {{ __('Roles & Permissions') }}
                </a>
                @endif
                @endif

                <div class="mx-3 my-4 h-px bg-white/5"></div>

                @if(auth()->user()->hasPermission('settings.statuses'))
                <a href="{{ route('admin.settings.statuses.trash') }}" class="sidebar-link flex items-center gap-3 rounded-xl px-3 py-2.5 {{ request()->routeIs('admin.settings.statuses.trash') ? 'admin-nav-active' : '' }}">
                    <div class="relative flex items-center justify-center">
                        <svg class="w-[18px] h-[18px] shrink-0 transition-colors group-hover:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        @php 
                            $statusTrashCount = \App\Models\ComplaintStatus::onlyTrashed()->count();
                            $questionTrashCount = \App\Models\ComplaintQuestion::onlyTrashed()->count();
                            $totalTrashCount = $statusTrashCount + $questionTrashCount;
                        @endphp
                        @if($totalTrashCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 h-3 w-3 flex items-center justify-center rounded-full bg-rose-500 text-[8px] font-black leading-none text-white ring-2 ring-[#111827]"></span>
                        @endif
                    </div>
                    <span class="flex-1">{{ __('System Trash') }}</span>
                </a>
                @endif
            </nav>

            {{-- Footer --}}
            <div class="p-3 text-[13px]">
                <div class="mx-1 mb-2 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                <div class="flex items-center gap-3 px-3 py-2">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 text-xs font-bold text-white uppercase">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold text-slate-300 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate">
                            {{ auth()->user()->is_admin ? __('Super Admin') : (auth()->user()->role?->label ?? __('No role')) }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.profile') }}" class="sidebar-link flex items-center gap-2.5 rounded-xl px-3 py-2 mt-1 {{ request()->routeIs('admin.profile') ? 'admin-nav-active' : 'text-slate-500' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    {{ __('My Profile') }}
                </a>
                <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-2.5 rounded-xl px-3 py-2 text-slate-500 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    {{ __('View site') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left flex items-center gap-2.5 rounded-xl px-3 py-2 text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        {{ __('Log out') }}
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content area --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="sticky top-0 z-10 bg-[#f0f2f7]/80 backdrop-blur-xl border-b border-slate-200/60 px-6 lg:px-8 py-5">
                <h1 class="text-xl font-bold tracking-tight text-slate-900">@yield('heading')</h1>
                @hasSection('subheading')
                    <p class="text-sm text-slate-500 mt-1 max-w-3xl leading-relaxed">@yield('subheading')</p>
                @endif
            </header>

            <div class="p-6 lg:p-8 flex-1 admin-content">
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-200/60 text-emerald-900 px-5 py-4 text-sm font-medium shadow-sm">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-500 text-white shrink-0">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </span>
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200/60 text-red-900 px-5 py-4 text-sm shadow-sm">
                        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
