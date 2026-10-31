<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Portal Akses — PKBM AL-QUDWAH</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-800">
        <div class="min-h-screen flex items-center justify-center relative overflow-hidden p-4 sm:p-6 lg:p-8">
            <!-- Ambient Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950"></div>
            <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-5xl grid grid-cols-1 md:grid-cols-12 rounded-3xl shadow-2xl overflow-hidden bg-white border border-white/10">
                <!-- Left Side: Branding Panel -->
                <div class="hidden md:flex md:col-span-5 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 flex-col justify-between p-10 text-white relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-indigo-400/20 blur-2xl"></div>

                    <div class="relative z-10">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-100 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Beranda
                        </a>
                    </div>

                    <div class="relative z-10 my-auto py-8">
                        <div class="w-20 h-20 rounded-2xl bg-white p-2.5 shadow-xl mb-6 flex items-center justify-center">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="w-full h-full object-contain">
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-blue-100 backdrop-blur-sm border border-white/20 mb-3">
                            Computer Based Test (CBT)
                        </span>
                        <h1 class="text-3xl font-extrabold tracking-tight leading-tight">
                            PKBM AL-QUDWAH
                        </h1>
                        <p class="text-blue-100/90 text-sm leading-relaxed mt-3">
                            Platform evaluasi pembelajaran digital terpadu. Masuk menggunakan kredensial resmi untuk mengakses dashboard ujian, bank soal, dan laporan nilai.
                        </p>
                    </div>

                    <div class="relative z-10 text-xs text-blue-200/80 font-medium flex items-center justify-between border-t border-white/15 pt-4">
                        <span>&copy; {{ date('Y') }} PKBM AL-QUDWAH</span>
                        <span>Sistem Terverifikasi</span>
                    </div>
                </div>

                <!-- Right Side: Auth Form -->
                <div class="md:col-span-7 p-8 sm:p-10 lg:p-12 flex flex-col justify-center bg-white">
                    <!-- Mobile Brand Header -->
                    <div class="md:hidden flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="w-10 h-10 rounded-xl object-contain border border-slate-200 p-1">
                            <div>
                                <h2 class="text-base font-extrabold text-slate-900 leading-none">PKBM AL-QUDWAH</h2>
                                <span class="text-xs font-semibold text-blue-600">Portal Ujian CBT</span>
                            </div>
                        </div>
                        <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600">Beranda &rarr;</a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
