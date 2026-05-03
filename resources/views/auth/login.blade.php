<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ __('Welcome back') }}</h1>
        <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ __('Enter your email and password to continue.') }}</p>
    </div>

    <x-auth-session-status class="mb-6 rounded-xl border border-emerald-200/80 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full border border-slate-300 shadow-sm focus:ring-2 focus:ring-teal-500/20 transition-all font-medium py-3.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1.5 block w-full border border-slate-300 shadow-sm focus:ring-2 focus:ring-teal-500/20 transition-all font-medium py-3.5"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4 pt-1">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded-md border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500 focus:ring-offset-0" name="remember">
                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-4 pt-2">
            <x-primary-button class="w-full justify-center py-3 text-sm font-semibold normal-case tracking-normal rounded-xl shadow-lg shadow-emerald-600/20">
                {{ __('Log in') }}
            </x-primary-button>


        </div>
    </form>
</x-guest-layout>
