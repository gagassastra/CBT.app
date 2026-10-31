<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PKBM AL-QUDWAH') }} — Sistem Ujian CBT</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full flex flex-col bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white overflow-x-hidden">
        <!-- Subtle Top Ambient Glow -->
        <div class="fixed inset-x-0 top-0 h-80 bg-gradient-to-b from-blue-100/40 via-indigo-50/20 to-transparent pointer-events-none -z-10"></div>

        @include('layouts.navigation')

        <!-- Optional Page Subheader -->
        @isset($header)
            <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 py-8">
            {{ $slot }}
        </main>

        <!-- App Footer -->
        <footer class="bg-white border-t border-slate-200/80 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-6 w-6 rounded-md object-contain border border-slate-200">
                    <span class="font-bold text-slate-700">PKBM AL-QUDWAH</span>
                    <span class="text-slate-300">&bull;</span>
                    <span>Computer Based Test (CBT)</span>
                </div>
                <div class="font-medium text-slate-400">
                    &copy; {{ date('Y') }} PKBM AL-QUDWAH. Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
