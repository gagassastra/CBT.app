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
                background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
            }
        </style>
    </head>
    <body class="antialiased text-slate-800 bg-slate-50 selection:bg-blue-200 selection:text-blue-900 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center space-x-3 cursor-pointer">
                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-10 w-10 object-contain rounded-lg border border-slate-100 shadow-sm">
                        <span class="text-xl font-extrabold text-slate-900 tracking-tight">PKBM AL-QUDWAH</span>
                    </div>
                    
                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#tentang-cbt" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Apa itu CBT?</a>
                        <a href="#tata-cara" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Tata Cara Ujian</a>
                    </div>

                    <div class="flex items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 px-5 py-2.5 rounded-full font-bold text-sm transition">
                                    Masuk Dashboard
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
        <main class="hero-gradient relative pt-32 pb-24 md:pt-40 md:pb-32 border-b border-slate-200">
            <div class="absolute inset-0 pattern-bg opacity-50"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-sm font-bold text-blue-700 mb-6">
                            <span class="w-2 h-2 rounded-full bg-blue-600 mr-2 animate-pulse"></span>
                            Portal Ujian Terintegrasi
                        </div>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-6 tracking-tight">
                            Evaluasi Belajar <br class="hidden lg:block" />
                            <span class="text-blue-600">Lebih Terstruktur</span>
                        </h1>
                        <p class="text-lg text-slate-600 mb-8 max-w-xl leading-relaxed">
                            Selamat datang di Portal Computer Based Test (CBT) PKBM AL-QUDWAH. Akses ujian sekolah Anda dengan sistem yang responsif, aman, dan dirancang khusus untuk kenyamanan evaluasi pembelajaran digital.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 rounded-full font-bold text-base transition-all hover:bg-blue-700 shadow-lg shadow-blue-600/30">
                                        Buka Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-blue-600 text-white px-8 py-3.5 rounded-full font-bold text-base transition-all hover:bg-blue-700 shadow-lg shadow-blue-600/30">
                                        Login Sekarang
                                    </a>
                                @endauth
                            @endif
                            <a href="#tentang-cbt" class="inline-flex items-center justify-center bg-white text-slate-700 border border-slate-300 px-8 py-3.5 rounded-full font-bold text-base transition-all hover:bg-slate-50">
                                Pelajari Sistem
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden lg:block relative">
                        <!-- Placeholder/Illustration container -->
                        <div class="relative w-full aspect-square max-w-md mx-auto">
                            <div class="absolute inset-0 bg-blue-100 rounded-full blur-3xl opacity-50 animate-pulse"></div>
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo Besar" class="relative z-10 w-full h-full object-contain drop-shadow-2xl p-12">
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Tentang CBT Section -->
        <section id="tentang-cbt" class="py-24 bg-white relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-4">Apa itu CBT?</h2>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        Computer Based Test (CBT) adalah sistem pelaksanaan ujian yang sepenuhnya dilakukan secara digital menggunakan perangkat komputer atau *smartphone*. Sistem ini menggantikan ujian berbasis kertas (Paper Based Test) untuk memberikan pengalaman yang lebih modern, efisien, dan transparan.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Waktu</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Waktu pengerjaan ujian terpusat pada sistem (server), sehingga seluruh siswa memiliki durasi yang presisi tanpa takut dicurangi.</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Sistem Autosave</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Setiap pilihan jawaban otomatis tersimpan ke server. Jika terjadi masalah perangkat atau koneksi, jawaban siswa tidak akan hilang.</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100">
                        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Nilai Real-time</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Setelah ujian berakhir, sistem secara instan akan mengkalkulasi skor siswa sehingga guru bisa langsung melihat rekapitulasi penilaian.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tata Cara Ujian (Simulasi) Section -->
        <section id="tata-cara" class="py-24 bg-slate-50 border-t border-slate-200 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-4">Tata Cara Penggunaan</h2>
                    <p class="text-lg text-slate-600">Panduan singkat bagi siswa baru mengenai bagaimana cara melaksanakan ujian di platform ini.</p>
                </div>

                <div class="space-y-12 max-w-4xl mx-auto">
                    <!-- Step 1 -->
                    <div class="flex flex-col sm:flex-row items-start gap-6 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex-shrink-0 w-14 h-14 bg-blue-600 text-white font-black text-2xl flex items-center justify-center rounded-xl">1</div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Login ke Sistem</h3>
                            <p class="text-slate-600 leading-relaxed">
                                Klik tombol <strong>Login</strong>, lalu masukkan <strong>NISN</strong> atau email beserta kata sandi yang telah diberikan oleh operator sekolah. Setelah berhasil, Anda akan masuk ke halaman Dashboard Siswa.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col sm:flex-row items-start gap-6 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex-shrink-0 w-14 h-14 bg-blue-600 text-white font-black text-2xl flex items-center justify-center rounded-xl">2</div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Pilih Ujian Aktif</h3>
                            <p class="text-slate-600 leading-relaxed">
                                Navigasi ke menu <strong>Daftar Ujian</strong>. Anda akan melihat daftar mata pelajaran yang dijadwalkan. Klik <strong>Kerjakan</strong> pada ujian yang statusnya sedang <em>Aktif</em>.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col sm:flex-row items-start gap-6 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex-shrink-0 w-14 h-14 bg-blue-600 text-white font-black text-2xl flex items-center justify-center rounded-xl">3</div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Jawab Soal dengan Teliti</h3>
                            <p class="text-slate-600 leading-relaxed">
                                Baca setiap butir soal, lalu pilih opsi jawaban (A, B, C, D, dsb) yang menurut Anda paling tepat. Tombol indikator soal akan berubah warna setelah Anda menjawab. Perhatikan sisa waktu pada timer di bagian atas layar.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col sm:flex-row items-start gap-6 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex-shrink-0 w-14 h-14 bg-blue-600 text-white font-black text-2xl flex items-center justify-center rounded-xl">4</div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Akhiri & Selesaikan Ujian</h3>
                            <p class="text-slate-600 leading-relaxed">
                                Jika semua soal sudah dikerjakan, klik tombol <strong>Selesai Ujian</strong>. Jika waktu habis (timer mencapai angka nol), sistem akan otomatis menyelesaikan ujian Anda dan menutup akses.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-16 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-slate-900 text-white px-8 py-4 rounded-full font-bold text-base transition-all hover:bg-slate-800 shadow-xl">
                        Mulai Simulasi / Login Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-10 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-md border border-slate-100">
                    <span class="font-extrabold text-slate-900 tracking-tight">PKBM AL-QUDWAH</span>
                </div>
                <div class="text-slate-500 text-sm font-medium">
                    &copy; {{ date('Y') }} Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
