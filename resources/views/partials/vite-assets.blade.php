@php
    $viteAvailable = file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'));
@endphp
@if ($viteAvailable)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    {{-- Run `npm install && npm run build` (or `npm run dev`) for full Tailwind v4 + Vite bundles. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
@endif
