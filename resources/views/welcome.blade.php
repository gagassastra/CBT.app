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
            .pattern-bg {
                background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
                background-size: 24px 24px;
            }
            .hero-gradient {
                background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #ffffff 100%);
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            @keyframes floating {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-15px); }
                100% { transform: translateY(0px); }
            }
            .timeline-line::before {
                content: '';
                position: absolute;
                top: 0;
                bottom: 0;
                left: 2rem;
                width: 2px;
                background: #e2e8f0;
                z-index: 0;
            }
            @media (max-width: 639px) {
                .timeline-line::before {
                    left: 1.5rem;
                }
            }
        </style>
    </head>
    <body class="antialiased text-slate-800 bg-slate-50 selection:bg-blue-200 selection:text-blue-900 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/60 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center space-x-2 sm:space-x-3 cursor-pointer">
                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-8 w-8 sm:h-10 sm:w-10 object-contain rounded-lg border border-slate-100 shadow-sm">
                        <span class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-none">PKBM <br class="block sm:hidden"><span class="text-blue-600 sm:text-slate-900">AL-QUDWAH</span></span>
                    </div>
                    
                    <div class="hidden md:flex space-x-8 items-center bg-slate-50/50 px-6 py-2 rounded-full border border-slate-200/60">
                        <a href="#tentang-cbt" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Apa itu CBT?</a>
                        <a href="#tata-cara" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">Tata Cara</a>
                    </div>

                    <div class="flex items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 px-4 sm:px-5 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition">
                                    Dashboard
                                    <svg class="w-4 h-4 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition shadow-lg shadow-blue-500/20">
                                    Login Sistem
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="hero-gradient relative pt-32 pb-20 md:pt-40 md:pb-28 border-b border-slate-200/80 overflow-hidden">
            <div class="absolute inset-0 pattern-bg opacity-40"></div>
            
            <!-- Decorative Blobs -->
            <div class="absolute top-20 left-0 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-40 right-0 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center text-center lg:text-left">
                    <div class="flex flex-col items-center lg:items-start order-2 lg:order-1">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-blue-100 text-xs sm:text-sm font-bold text-blue-700 mb-6 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-blue-600 mr-2 animate-pulse"></span>
                            Portal Ujian Terintegrasi
                        </div>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-6xl font-extrabold text-slate-900 leading-[1.15] mb-6 tracking-tight">
                            Evaluasi Belajar <br class="hidden sm:block" />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Lebih Terstruktur</span>
                        </h1>
                        <p class="text-base sm:text-lg text-slate-600 mb-8 max-w-xl leading-relaxed mx-auto lg:mx-0">
                            Selamat datang di Portal Computer Based Test (CBT) PKBM AL-QUDWAH. Akses ujian sekolah Anda dengan sistem yang responsif, aman, dan dirancang khusus untuk kenyamanan evaluasi pembelajaran digital.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 w-full sm:w-auto px-4 sm:px-0">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 sm:py-4 rounded-full font-bold text-sm sm:text-base transition-all hover:bg-blue-700 hover:-translate-y-0.5 shadow-lg shadow-blue-600/30">
                                        Buka Dashboard
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 sm:py-4 rounded-full font-bold text-sm sm:text-base transition-all hover:bg-blue-700 hover:-translate-y-0.5 shadow-lg shadow-blue-600/30">
                                        Login Sekarang
                                    </a>
                                @endauth
                            @endif
                            <a href="#tentang-cbt" class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-slate-700 border border-slate-200 px-8 py-3.5 sm:py-4 rounded-full font-bold text-sm sm:text-base transition-all hover:bg-slate-50 hover:-translate-y-0.5 shadow-sm">
                                Pelajari Sistem
                            </a>
                        </div>
                    </div>
                    
                    <div class="order-1 lg:order-2 relative w-full max-w-xs sm:max-w-md mx-auto">
                        <!-- Illustration container -->
                        <div class="relative w-full aspect-square floating">
                            <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-indigo-50 rounded-full blur-2xl opacity-70"></div>
                            <div class="absolute inset-4 bg-white rounded-full shadow-2xl border border-white flex items-center justify-center p-8 sm:p-12">
                                <img src="{{ asset('image/logo.jpg') }}" alt="Logo Besar" class="relative z-10 w-full h-full object-contain">
                            </div>
                            
                            <!-- Floating decorative elements -->
                            <div class="absolute -right-4 top-10 bg-white p-3 rounded-2xl shadow-xl border border-slate-100 animate-bounce" style="animation-duration: 3s;">
                                <span class="text-2xl">📝</span>
                            </div>
                            <div class="absolute -left-6 bottom-20 bg-white p-3 rounded-2xl shadow-xl border border-slate-100 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                                <span class="text-2xl">⏱️</span>
                            </div>
                            <div class="absolute right-10 -bottom-6 bg-white px-4 py-2 rounded-full shadow-xl border border-slate-100 flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="text-xs font-bold text-slate-700">Sistem Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Tentang CBT Section -->
        <section id="tentang-cbt" class="py-20 md:py-28 bg-white relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4 md:mb-6">Apa itu CBT?</h2>
                    <p class="text-base md:text-lg text-slate-600 leading-relaxed px-4 sm:px-0">
                        Computer Based Test (CBT) adalah sistem pelaksanaan ujian yang sepenuhnya dilakukan secara digital menggunakan perangkat komputer atau *smartphone*. Sistem ini dirancang untuk memberikan pengalaman yang lebih modern, efisien, dan transparan.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                    <!-- Feature 1 -->
                    <div class="group bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Waktu</h3>
                        <p class="text-slate-600 text-sm md:text-base leading-relaxed">Waktu pengerjaan ujian terpusat pada sistem server. Hal ini memastikan seluruh siswa memiliki durasi yang sangat presisi dan terhindar dari kecurangan.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="group bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Sistem Autosave</h3>
                        <p class="text-slate-600 text-sm md:text-base leading-relaxed">Setiap pilihan jawaban otomatis tersimpan ke server secara real-time. Jika perangkat mati atau koneksi terputus, jawaban siswa tidak akan hilang.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="group bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Nilai Real-time</h3>
                        <p class="text-slate-600 text-sm md:text-base leading-relaxed">Sistem secara instan mengkalkulasi skor siswa sesaat setelah ujian berakhir. Guru bisa langsung memantau dan mencetak rekapitulasi nilai.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tata Cara Ujian (Simulasi) Section -->
        <section id="tata-cara" class="py-20 md:py-28 bg-slate-50 border-t border-slate-200 relative z-10 overflow-hidden">
            <div class="absolute inset-0 pattern-bg opacity-30"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4 md:mb-6">Tata Cara Penggunaan</h2>
                    <p class="text-base md:text-lg text-slate-600 px-4 sm:px-0">Panduan singkat bagi siswa mengenai langkah-langkah pelaksanaan ujian di portal ini.</p>
                </div>

                <div class="relative max-w-4xl mx-auto timeline-line py-4">
                    <!-- Step 1 -->
                    <div class="relative flex items-start gap-4 sm:gap-8 mb-12 group">
                        <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-blue-600 text-white font-black text-xl sm:text-2xl flex items-center justify-center rounded-full shadow-lg shadow-blue-500/30 z-10 border-4 border-slate-50 group-hover:scale-110 transition-transform">
                            1
                        </div>
                        <div class="glass-card w-full p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Login ke Sistem</h3>
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                                Klik tombol <strong>Login</strong>, masukkan <strong>NISN</strong> atau Email beserta Kata Sandi yang telah diberikan oleh pihak sekolah. Setelah berhasil, Anda akan diarahkan ke halaman Dashboard Utama.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex items-start gap-4 sm:gap-8 mb-12 group">
                        <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-blue-600 text-white font-black text-xl sm:text-2xl flex items-center justify-center rounded-full shadow-lg shadow-blue-500/30 z-10 border-4 border-slate-50 group-hover:scale-110 transition-transform">
                            2
                        </div>
                        <div class="glass-card w-full p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Pilih Ujian Aktif</h3>
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                                Buka menu <strong>Daftar Ujian</strong>. Anda akan melihat seluruh daftar mata pelajaran yang dijadwalkan. Klik tombol <strong>Kerjakan</strong> pada ujian yang statusnya sedang <em>Aktif</em>.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex items-start gap-4 sm:gap-8 mb-12 group">
                        <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-blue-600 text-white font-black text-xl sm:text-2xl flex items-center justify-center rounded-full shadow-lg shadow-blue-500/30 z-10 border-4 border-slate-50 group-hover:scale-110 transition-transform">
                            3
                        </div>
                        <div class="glass-card w-full p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Jawab Soal dengan Teliti</h3>
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                                Baca butir soal dengan seksama, lalu klik opsi jawaban yang menurut Anda paling benar. Indikator navigasi soal akan berubah warna setelah Anda menjawab. Selalu perhatikan sisa waktu pada <em>timer</em> di layar.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex items-start gap-4 sm:gap-8 group">
                        <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-blue-600 text-white font-black text-xl sm:text-2xl flex items-center justify-center rounded-full shadow-lg shadow-blue-500/30 z-10 border-4 border-slate-50 group-hover:scale-110 transition-transform">
                            4
                        </div>
                        <div class="glass-card w-full p-6 sm:p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2 sm:mb-3">Akhiri & Selesaikan Ujian</h3>
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                                Jika semua soal telah dikerjakan, tekan tombol <strong>Selesai Ujian</strong>. Jika waktu habis, sistem akan secara otomatis menyimpan jawaban dan mengakhiri sesi ujian Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-16 sm:mt-20 text-center px-4 sm:px-0">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-slate-900 text-white px-8 sm:px-10 py-4 sm:py-4 rounded-full font-bold text-sm sm:text-base transition-all hover:bg-slate-800 hover:-translate-y-1 shadow-xl shadow-slate-900/20">
                        Mulai Simulasi / Login Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-8 sm:py-10 mt-auto relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-md border border-slate-100">
                    <span class="font-extrabold text-slate-900 tracking-tight text-sm sm:text-base">PKBM AL-QUDWAH</span>
                </div>
                <div class="text-slate-500 text-xs sm:text-sm font-medium text-center md:text-right">
                    &copy; {{ date('Y') }} Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
