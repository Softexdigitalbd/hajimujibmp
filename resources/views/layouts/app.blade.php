<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @include('partials.vite-assets')
        <style>
            *, *::before, *::after { box-sizing: border-box; }
            html { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
            body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }

            /* Smooth page transitions */
            .page-enter { animation: pageEnter 0.4s ease-out; }
            @keyframes pageEnter {
                from { opacity: 0; transform: translateY(8px); }
                to   { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="antialiased text-slate-900 bg-gradient-to-br from-slate-50 via-white to-slate-100/80 min-h-screen">

        @include('layouts.navigation')

        @isset($header)
            <div class="border-b border-slate-200/60 bg-white/80 backdrop-blur-sm">
                <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between py-6 sm:py-7">
                        {{ $header }}
                    </div>
                </div>
            </div>
        @endisset

        <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8 page-enter">
            {{ $slot }}
        </main>

    </body>
</html>
