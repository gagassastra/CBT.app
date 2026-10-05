<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Ujian CBT - PKBM AL-QUDWAH</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .bg-grid {
                background-image: radial-gradient(rgba(148, 163, 184, 0.3) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            .bg-grid-dark {
                background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-15px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="antialiased text-slate-800 bg-slate-50 selection:bg-blue-200 selection:text-blue-900 flex flex-col min-h-screen">
        
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-10 w-10 object-contain rounded-lg border border-slate-100 shadow-sm">
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight hidden sm:block">PKBM AL-QUDWAH</span>
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight sm:hidden">PKBM</span>
                    </div>
                    
                    <div class="hidden md:flex space-x-8 items-center bg-slate-50/80 px-6 py-2 rounded-full border border-slate-200">
                        <a href="#tentang-cbt" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Apa itu CBT?</a>
                        <a href="#tata-cara" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Tata Cara Ujian</a>
                    </div>

                    <div class="flex items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 px-5 py-2.5 rounded-full font-bold text-sm transition">
                                    Dashboard
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full font-bold text-sm transition shadow-md shadow-blue-500/20">
                                    Login Sistem
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative bg-gradient-to-br from-blue-50 via-white to-indigo-50 pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden">
            <div class="absolute inset-0 bg-grid opacity-60"></div>
            
            <!-- Colorful Glowing Orbs -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
                <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-blue-400/20 blur-[120px]"></div>
                <div class="absolute top-[20%] -right-[10%] w-[40%] h-[60%] rounded-full bg-indigo-400/20 blur-[120px]"></div>
                <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[50%] rounded-full bg-purple-400/20 blur-[120px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    
                    <!-- Text Content -->
                    <div class="text-center lg:text-left flex flex-col items-center lg:items-start">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-blue-100 text-sm font-bold text-blue-700 mb-6 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-blue-600 mr-2 animate-pulse"></span>
                            Portal Ujian Terintegrasi
                        </div>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6 tracking-tight">
                            Evaluasi Belajar <br class="hidden lg:block" />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Lebih Terstruktur</span>
                        </h1>
                        <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed mx-auto lg:mx-0">
                            Selamat datang di Portal Computer Based Test (CBT) PKBM AL-QUDWAH. Akses ujian sekolah Anda dengan sistem yang responsif, aman, dan dirancang khusus untuk kenyamanan evaluasi pembelajaran digital.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto px-4 sm:px-0">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 rounded-full font-bold text-base transition-all hover:bg-blue-700 hover:-translate-y-0.5 shadow-[0_0_20px_rgba(37,99,235,0.3)]">
                                        Buka Dashboard
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 rounded-full font-bold text-base transition-all hover:bg-blue-700 hover:-translate-y-0.5 shadow-[0_0_20px_rgba(37,99,235,0.3)]">
                                        Login Sekarang
                                    </a>
                                @endauth
                            @endif
                            <a href="#tentang-cbt" class="w-full sm:w-auto inline-flex items-center justify-center bg-white/80 backdrop-blur-sm text-slate-700 border border-slate-300 px-8 py-3.5 rounded-full font-bold text-base transition-all hover:bg-white hover:-translate-y-0.5 shadow-sm">
                                Pelajari Sistem
                            </a>
                        </div>
                    </div>
                    
                    <!-- Image Content -->
                    <div class="relative w-full max-w-[14rem] sm:max-w-[18rem] lg:max-w-[22rem] mx-auto animate-float">
                        <div class="absolute inset-0 bg-blue-400 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                        <div class="relative bg-white rounded-full shadow-2xl border-[6px] sm:border-[8px] border-white overflow-hidden flex items-center justify-center aspect-square">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo Besar" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <!-- Tentang CBT Section -->
        <section id="tentang-cbt" class="py-20 bg-white relative z-10 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Apa itu CBT?</h2>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        Computer Based Test (CBT) adalah sistem pelaksanaan ujian yang sepenuhnya dilakukan secara digital menggunakan perangkat komputer atau <em>smartphone</em>. Sistem ini menggantikan ujian berbasis kertas untuk memberikan pengalaman yang lebih modern, efisien, dan transparan.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-3xl p-8 border border-blue-100 shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Waktu</h3>
                        <p class="text-slate-600 leading-relaxed">Waktu pengerjaan ujian terpusat pada sistem server. Memastikan seluruh siswa memiliki durasi yang presisi tanpa takut dicurangi.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-3xl p-8 border border-emerald-100 shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Sistem Autosave</h3>
                        <p class="text-slate-600 leading-relaxed">Setiap pilihan jawaban otomatis tersimpan ke server secara real-time. Jawaban tidak akan hilang meskipun koneksi terputus.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-3xl p-8 border border-purple-100 shadow-sm hover:shadow-xl hover:shadow-purple-900/5 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Nilai Real-time</h3>
                        <p class="text-slate-600 leading-relaxed">Sistem langsung melakukan kalkulasi rekap nilai seketika setelah ujian berakhir. Guru bisa langsung memantau secara otomatis.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tata Cara Ujian (Simulasi) Section -->
        <section id="tata-cara" class="py-24 bg-slate-900 relative z-10 overflow-hidden">
            <div class="absolute inset-0 bg-grid-dark opacity-30"></div>
            
            <!-- Dark Glowing Orbs -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">Tata Cara Penggunaan</h2>
                    <p class="text-lg text-slate-300">Panduan langkah demi langkah bagi siswa mengenai tata cara pelaksanaan ujian di portal CBT.</p>
                </div>

                <div class="max-w-4xl mx-auto space-y-6">
                    <!-- Step 1 -->
                    <div class="bg-slate-800/60 backdrop-blur-sm p-6 sm:p-8 rounded-2xl border border-slate-700/50 shadow-lg flex flex-col sm:flex-row items-start gap-6 hover:bg-slate-800 transition-colors">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-black text-2xl flex items-center justify-center rounded-2xl shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            1
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">Login ke Sistem</h3>
                            <p class="text-slate-300 leading-relaxed">
                                Klik tombol <strong class="text-white">Login</strong>, lalu masukkan <strong class="text-white">NISN</strong> atau email beserta kata sandi yang telah diberikan oleh operator sekolah. Setelah berhasil, Anda akan masuk ke halaman Dashboard Siswa.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-slate-800/60 backdrop-blur-sm p-6 sm:p-8 rounded-2xl border border-slate-700/50 shadow-lg flex flex-col sm:flex-row items-start gap-6 hover:bg-slate-800 transition-colors">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-black text-2xl flex items-center justify-center rounded-2xl shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            2
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">Pilih Ujian Aktif</h3>
                            <p class="text-slate-300 leading-relaxed">
                                Navigasi ke menu <strong class="text-white">Daftar Ujian</strong>. Anda akan melihat daftar mata pelajaran yang dijadwalkan. Klik <strong class="text-white">Kerjakan</strong> pada ujian yang statusnya sedang <em class="text-blue-300">Aktif</em>.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-slate-800/60 backdrop-blur-sm p-6 sm:p-8 rounded-2xl border border-slate-700/50 shadow-lg flex flex-col sm:flex-row items-start gap-6 hover:bg-slate-800 transition-colors">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-black text-2xl flex items-center justify-center rounded-2xl shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            3
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">Jawab Soal dengan Teliti</h3>
                            <p class="text-slate-300 leading-relaxed">
                                Baca setiap butir soal, lalu pilih opsi jawaban (A, B, C, D) yang menurut Anda paling tepat. Tombol indikator soal akan berubah warna setelah Anda menjawab. Perhatikan sisa waktu pada timer di bagian atas layar.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-slate-800/60 backdrop-blur-sm p-6 sm:p-8 rounded-2xl border border-slate-700/50 shadow-lg flex flex-col sm:flex-row items-start gap-6 hover:bg-slate-800 transition-colors">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-black text-2xl flex items-center justify-center rounded-2xl shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            4
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">Akhiri & Selesaikan Ujian</h3>
                            <p class="text-slate-300 leading-relaxed">
                                Jika semua soal sudah dikerjakan, klik tombol <strong class="text-white">Selesai Ujian</strong>. Jika waktu habis, sistem akan otomatis menyelesaikan ujian Anda dan menutup akses secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-8 sm:px-12 py-4 rounded-full font-extrabold text-base transition-all hover:bg-blue-500 hover:scale-105 shadow-[0_0_20px_rgba(37,99,235,0.4)]">
                        Mulai Simulasi Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-10 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-md border border-slate-100">
                    <span class="font-extrabold text-slate-900 tracking-tight text-base">PKBM AL-QUDWAH</span>
                </div>
                <div class="text-slate-500 text-sm font-medium">
                    &copy; {{ date('Y') }} Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
