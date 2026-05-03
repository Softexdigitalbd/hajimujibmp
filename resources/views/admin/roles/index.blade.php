@extends('layouts.admin')

@section('title', __('Role Management'))
@section('heading', __('Role Management'))
@section('subheading', __('Create roles and configure their permissions to control admin panel access.'))

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <span class="font-semibold text-slate-800">{{ $roles->count() }}</span> {{ __('roles defined') }}
        </div>
        @if(auth()->user()->hasPermission('roles.create'))
        <a href="{{ route('admin.roles.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all hover:shadow-xl hover:-translate-y-0.5">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            {{ __('Create Role') }}
        </a>
        @endif
    </div>

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-2xl bg-red-50 border border-red-200/60 text-red-800 px-5 py-4 text-sm font-medium">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Roles Grid --}}
    @if($roles->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 rounded-2xl border border-dashed border-slate-200 bg-white text-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-4">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-600">{{ __('No roles yet') }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ __('Create your first role to start assigning permissions.') }}</p>
            @if(auth()->user()->hasPermission('roles.create'))
            <a href="{{ route('admin.roles.create') }}"
               class="mt-4 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                {{ __('Create First Role') }}
            </a>
            @endif
        </div>
    @else
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($roles as $role)
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md hover:border-indigo-200">
            {{-- Decoration --}}
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-indigo-50 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <h3 class="font-bold text-slate-800">{{ $role->label }}</h3>
                    <code class="text-[11px] text-slate-400 font-mono">{{ $role->name }}</code>
                </div>
                <div class="flex shrink-0 items-center gap-1">
                    @if(auth()->user()->hasPermission('roles.edit'))
                    <a href="{{ route('admin.roles.edit', $role) }}"
                       class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-indigo-100 hover:text-indigo-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    </a>
                    @endif
                    @if(auth()->user()->hasPermission('roles.delete'))
                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                          onsubmit="return confirm('{{ __('Delete this role? Users with this role will lose access.') }}')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-red-50 hover:text-red-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($role->description)
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">{{ $role->description }}</p>
            @endif

            <div class="flex items-center gap-4 text-xs text-slate-500">
                <span class="flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    <span class="font-semibold text-slate-700">{{ $role->users_count }}</span> {{ __('user(s)') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    <span class="font-semibold text-slate-700">{{ $role->permissions_count }}</span> {{ __('permission(s)') }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
