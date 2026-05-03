@extends('layouts.admin')

@section('title', __('Create User'))
@section('heading', __('Create New User'))
@section('subheading', __('Add a new staff member and assign their role.'))

@section('content')
<div class="max-w-2xl">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-6 py-4">
            <h2 class="text-sm font-bold text-slate-800">{{ __('User Details') }}</h2>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Full Name') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 @error('name') border-red-300 bg-red-50 @enderror"
                    placeholder="{{ __('e.g. John Doe') }}">
                @error('name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Email Address') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 @error('email') border-red-300 bg-red-50 @enderror"
                    placeholder="user@example.com">
                @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 @error('password') border-red-300 bg-red-50 @enderror"
                        placeholder="••••••••">
                    @error('password')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                        placeholder="••••••••">
                </div>
            </div>

            {{-- Role (single selection) --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">{{ __('Assign Role') }}</label>
                @if($roles->isEmpty())
                    <p class="text-sm text-slate-400 italic">{{ __('No roles created yet.') }}
                        <a href="{{ route('admin.roles.create') }}" class="text-indigo-500 underline">{{ __('Create a role first') }}</a>.
                    </p>
                @else
                <div class="space-y-2">
                    {{-- No role option --}}
                    <label for="role_none"
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-slate-300 has-[:checked]:border-slate-400 has-[:checked]:bg-slate-50">
                        <input type="radio" id="role_none" name="role_id" value=""
                            class="h-4 w-4 border-slate-300 text-slate-600 focus:ring-slate-400"
                            {{ old('role_id') === null ? 'checked' : '' }}>
                        <div>
                            <p class="text-sm font-semibold text-slate-600">{{ __('No Role') }}</p>
                            <p class="text-xs text-slate-400">{{ __('User can log in but has no permissions.') }}</p>
                        </div>
                    </label>
                    @foreach($roles as $role)
                    <label for="role_{{ $role->id }}"
                        class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-indigo-300 hover:bg-indigo-50/40 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50">
                        <input type="radio" id="role_{{ $role->id }}" name="role_id" value="{{ $role->id }}"
                            class="h-4 w-4 border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            {{ old('role_id') == $role->id ? 'checked' : '' }}>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">{{ $role->label }}</p>
                            @if($role->description)
                                <p class="text-xs text-slate-400 mt-0.5">{{ $role->description }}</p>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
                @endif
                @error('role_id')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    {{ __('Create User') }}
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
