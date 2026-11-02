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
    <body class="min-h-full flex flex-col bg-gradient-to-br from-slate-100 via-blue-50/70 to-indigo-100/60 text-slate-800 antialiased selection:bg-indigo-600 selection:text-white overflow-x-hidden relative">
        <!-- Decorative Ambient Background Orbs -->
        <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-400/15 blur-3xl"></div>
            <div class="absolute top-1/3 -right-24 w-96 h-96 rounded-full bg-indigo-400/15 blur-3xl"></div>
            <div class="absolute -bottom-24 left-1/3 w-96 h-96 rounded-full bg-violet-400/10 blur-3xl"></div>
        </div>

        @include('layouts.navigation')

        <!-- Optional Page Subheader -->
        @isset($header)
            <header class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-950 text-white border-b border-indigo-500/20 shadow-md">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 py-8">
            {{ $slot }}
        </main>

        <!-- App Footer -->
        <footer class="bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 border-t border-indigo-500/20 mt-auto text-slate-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2.5">
                    <div class="p-0.5 rounded-lg bg-white/10 border border-white/15">
                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-6 w-6 rounded-md object-contain">
                    </div>
                    <span class="font-bold text-white tracking-wide">PKBM AL-QUDWAH</span>
                    <span class="text-indigo-400">&bull;</span>
                    <span class="text-blue-200/80">Computer Based Test (CBT)</span>
                </div>
                <div class="font-medium text-blue-200/70">
                    &copy; {{ date('Y') }} PKBM AL-QUDWAH. Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
