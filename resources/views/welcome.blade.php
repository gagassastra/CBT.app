<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Ujian CBT — PKBM AL-QUDWAH</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .bg-grid {
                background-image: radial-gradient(rgba(148, 163, 184, 0.28) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            .bg-grid-dark {
                background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
                background-size: 24px 24px;
            }
        </style>
    </head>
    <body class="antialiased text-slate-800 bg-slate-50 selection:bg-blue-600 selection:text-white flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16 sm:h-20">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="p-1.5 rounded-xl bg-blue-50 border border-blue-100 shadow-xs">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-8 w-8 sm:h-9 sm:w-9 object-contain rounded-lg">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight leading-none">PKBM AL-QUDWAH</span>
                            <span class="text-[11px] font-semibold text-blue-600 tracking-wide mt-0.5">Computer Based Test</span>
                        </div>
                    </a>

                    <div class="hidden md:flex space-x-8 items-center bg-slate-100/80 px-6 py-2 rounded-full border border-slate-200/80">
                        <a href="#tentang-cbt" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Keunggulan CBT</a>
                        <a href="#tata-cara" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Panduan Peserta</a>
                    </div>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="ui-btn-primary rounded-full px-5 py-2.5">
                                    Buka Dashboard
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="ui-btn-primary rounded-full px-6 py-2.5">
                                    Masuk Sistem
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative bg-gradient-to-br from-blue-50/70 via-white to-indigo-50/60 pt-28 pb-20 sm:pt-36 sm:pb-24 lg:pt-40 lg:pb-28 overflow-hidden">
            <div class="absolute inset-0 bg-grid opacity-60"></div>

            <!-- Ambient Glow -->
            <div class="absolute inset-0 overflow-hidden z-0 pointer-events-none">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-400/15 blur-3xl"></div>
                <div class="absolute top-1/4 -right-24 w-96 h-96 rounded-full bg-indigo-400/15 blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
                    <!-- Left Column -->
                    <div class="lg:col-span-7 text-center lg:text-left flex flex-col items-center lg:items-start">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-xs sm:text-sm font-bold text-blue-700 mb-6 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                            Portal Evaluasi Pembelajaran Digital Resmi
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-[3.4rem] font-extrabold text-slate-900 leading-[1.15] mb-6 tracking-tight">
                            Pelaksanaan Ujian Sekolah <br class="hidden sm:block" />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Modern, Jujur & Terukur</span>
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 mb-8 max-w-2xl leading-relaxed">
                            Selamat datang di Sistem Computer Based Test (CBT) <strong>PKBM AL-QUDWAH</strong>. Dirancang untuk kemudahan akses siswa, efisiensi pengelolaan bank soal guru, serta keakuratan rekapitulasi nilai secara <em>real-time</em>.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3.5 w-full sm:w-auto">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="ui-btn-primary rounded-2xl px-8 py-4 text-base">
                                        Buka Panel Dashboard
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="ui-btn-primary rounded-2xl px-8 py-4 text-base">
                                        Mulai Ujian / Login
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @endauth
                            @endif
                            <a href="#tata-cara" class="ui-btn-secondary rounded-2xl px-7 py-4 text-base">
                                Panduan Peserta
                            </a>
                        </div>

                        <!-- Quick Trust Badges -->
                        <div class="mt-10 pt-8 border-t border-slate-200/70 grid grid-cols-3 gap-6 w-full max-w-lg">
                            <div>
                                <p class="text-xl sm:text-2xl font-extrabold text-slate-900">Autosave</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Jawaban Tersimpan Otomatis</p>
                            </div>
                            <div>
                                <p class="text-xl sm:text-2xl font-extrabold text-slate-900">Real-Time</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Kalkulasi Skor Instan</p>
                            </div>
                            <div>
                                <p class="text-xl sm:text-2xl font-extrabold text-slate-900">Responsif</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Komputer & Smartphone</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Visual CBT Preview Card -->
                    <div class="lg:col-span-5">
                        <div class="relative mx-auto max-w-md lg:max-w-none">
                            <div class="absolute -inset-2 rounded-3xl bg-gradient-to-r from-blue-500 to-indigo-600 opacity-15 blur-2xl"></div>
                            <div class="relative bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
                                <!-- Mockup Topbar -->
                                <div class="bg-slate-900 px-5 py-4 flex items-center justify-between text-white">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-lg object-contain bg-white p-0.5">
                                        <div>
                                            <p class="text-xs font-bold leading-none">PKBM AL-QUDWAH</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Simulasi Lembar Ujian CBT</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                        45:00
                                    </span>
                                </div>

                                <!-- Mockup Body -->
                                <div class="p-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">Soal #1 dari 25</span>
                                        <span class="text-xs font-semibold text-slate-400">Pilihan Ganda & Esai</span>
                                    </div>

                                    <p class="text-sm font-semibold text-slate-800 leading-relaxed bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                                        Sistem evaluasi berbasis komputer memastikan setiap jawaban peserta tersimpan secara aman dan terstruktur.
                                    </p>

                                    <div class="space-y-2.5">
                                        <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-blue-600 bg-blue-50/60">
                                            <span class="w-6 h-6 rounded-lg bg-blue-600 text-white text-xs font-bold flex items-center justify-center">A</span>
                                            <span class="text-xs font-bold text-blue-900">Tersimpan otomatis ke server</span>
                                            <svg class="w-4 h-4 text-blue-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-white">
                                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center">B</span>
                                            <span class="text-xs font-medium text-slate-600">Mendukung soal bergambar & video</span>
                                        </div>
                                        <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-white">
                                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center">C</span>
                                            <span class="text-xs font-medium text-slate-600">Rekapitulasi nilai & laporan PDF</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Tentang CBT Section -->
        <section id="tentang-cbt" class="py-20 bg-white relative z-10 border-t border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-600">Fitur Unggulan</span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mt-2 mb-4">Mengapa Menggunakan Portal CBT?</h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        Computer Based Test (CBT) menghadirkan standar pelaksanaan evaluasi akademik yang objektif, cepat, dan ramah pengguna baik melalui perangkat komputer maupun ponsel pintar.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-slate-50/70 hover:bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition-all duration-200">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-blue-600/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Manajemen Waktu Presisi</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Waktu pengerjaan ujian dihitung langsung dari server pusat, memastikan seluruh peserta mendapatkan durasi yang adil dan akurat.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-slate-50/70 hover:bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition-all duration-200">
                        <div class="w-12 h-12 bg-emerald-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-emerald-600/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Penyimpanan Otomatis (Autosave)</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Setiap jawaban pilihan ganda maupun esai langsung tersimpan ke basis data secara <em>real-time</em> tanpa khawatir hilang jika halaman tertutup.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-slate-50/70 hover:bg-white rounded-2xl p-7 border border-slate-200/80 shadow-xs hover:shadow-lg transition-all duration-200">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-5 shadow-md shadow-indigo-600/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Rekapitulasi & Laporan Instan</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Hasil ujian pilihan ganda dihitung otomatis disertai fasilitas koreksi esai dan pencetakan laporan resmi berformat PDF.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tata Cara Ujian Section -->
        <section id="tata-cara" class="py-20 bg-slate-900 relative z-10 overflow-hidden">
            <div class="absolute inset-0 bg-grid-dark opacity-40"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <span class="text-xs font-extrabold uppercase tracking-widest text-blue-400">Alur Pelaksanaan</span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight mt-2 mb-4">Tata Cara Mengikuti Ujian</h2>
                    <p class="text-base text-slate-300">Ikuti 4 langkah mudah berikut untuk mengerjakan ujian dengan lancar di portal CBT PKBM AL-QUDWAH.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
                    <div class="bg-slate-800/70 p-6 sm:p-7 rounded-2xl border border-slate-700/70 flex items-start gap-5">
                        <div class="shrink-0 w-12 h-12 bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center rounded-xl shadow-md">1</div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1.5">Masuk Menggunakan Akun Resmi</h3>
                            <p class="text-sm text-slate-300 leading-relaxed">Gunakan <strong>NISN</strong> dan kata sandi yang tertera pada Kartu Peserta Ujian Anda untuk masuk ke halaman Dashboard Siswa.</p>
                        </div>
                    </div>

                    <div class="bg-slate-800/70 p-6 sm:p-7 rounded-2xl border border-slate-700/70 flex items-start gap-5">
                        <div class="shrink-0 w-12 h-12 bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center rounded-xl shadow-md">2</div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1.5">Pilih Jadwal Ujian Aktif</h3>
                            <p class="text-sm text-slate-300 leading-relaxed">Buka menu <strong>Daftar Ujian</strong>, periksa mata pelajaran dan durasi waktu, kemudian klik tombol <strong>Mulai Kerjakan</strong>.</p>
                        </div>
                    </div>

                    <div class="bg-slate-800/70 p-6 sm:p-7 rounded-2xl border border-slate-700/70 flex items-start gap-5">
                        <div class="shrink-0 w-12 h-12 bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center rounded-xl shadow-md">3</div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1.5">Kerjakan Soal & Pantau Navigasi</h3>
                            <p class="text-sm text-slate-300 leading-relaxed">Pilih opsi jawaban yang tepat atau isi jawaban uraian. Gunakan panel nomor soal untuk berpindah soal dan memeriksa soal yang belum terjawab.</p>
                        </div>
                    </div>

                    <div class="bg-slate-800/70 p-6 sm:p-7 rounded-2xl border border-slate-700/70 flex items-start gap-5">
                        <div class="shrink-0 w-12 h-12 bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center rounded-xl shadow-md">4</div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-1.5">Kumpulkan Ujian</h3>
                            <p class="text-sm text-slate-300 leading-relaxed">Setelah seluruh soal terjawab, tekan tombol <strong>Kumpulkan Ujian</strong>. Apabila waktu habis, sistem akan menyimpan dan menutup ujian secara otomatis.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('login') }}" class="ui-btn-primary rounded-2xl px-8 py-4 text-base">
                        Masuk ke Portal Ujian Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-7 h-7 rounded-lg border border-slate-200 object-contain">
                    <span class="font-extrabold text-slate-900 tracking-tight text-sm">PKBM AL-QUDWAH</span>
                </div>
                <div class="text-slate-500 text-xs font-medium">
                    &copy; {{ date('Y') }} PKBM AL-QUDWAH. Sistem Evaluasi Pembelajaran Berbasis Komputer.
                </div>
            </div>
        </footer>
    </body>
</html>
