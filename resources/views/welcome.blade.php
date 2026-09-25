<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Ujian - PKBM AL-QUDWAH</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .mesh-bg {
                background-color: #f8fafc;
                background-image: 
                    radial-gradient(at 0% 0%, hsla(217,100%,70%,0.15) 0px, transparent 50%),
                    radial-gradient(at 100% 0%, hsla(250,100%,75%,0.15) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, hsla(217,100%,70%,0.15) 0px, transparent 50%),
                    radial-gradient(at 0% 100%, hsla(250,100%,75%,0.15) 0px, transparent 50%);
            }
            .grid-bg {
                background-image: linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
                background-size: 40px 40px;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 mesh-bg grid-bg min-h-screen flex flex-col relative selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">
        
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-white/60 border-b border-white/40 shadow-sm transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center space-x-3 group cursor-pointer">
                        <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-100 group-hover:shadow-md transition">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-9 w-9 object-contain rounded-lg">
                        </div>
                        <span class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-indigo-800 tracking-tighter whitespace-nowrap">PKBM AL-QUDWAH</span>
                    </div>
                    
                    <div class="flex items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-blue-600 transition flex items-center">
                                    Masuk Dashboard
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-gray-900 hover:bg-blue-600 text-white px-6 py-2.5 rounded-full font-bold text-sm transition-colors shadow-md hover:shadow-lg hover:shadow-blue-500/30">
                                    Login
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center justify-center relative z-10 px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="max-w-5xl mx-auto text-center flex flex-col items-center">
                
                <!-- Animated App Icon (Logo) -->
                <div class="relative mb-10 animate-float">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-400 blur-2xl opacity-40 rounded-3xl"></div>
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM" class="relative w-32 md:w-40 object-contain bg-white rounded-3xl shadow-2xl p-4 border border-white/50">
                </div>
                
                <!-- Status Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white border border-gray-200 shadow-sm text-sm font-bold text-gray-700 mb-8 backdrop-blur-md">
                    <span class="relative flex h-2.5 w-2.5 mr-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                    </span>
                    Sistem Computer Based Test Aktif
                </div>

                <!-- Main Heading -->
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-gray-900 leading-[1.1] mb-8 tracking-tighter">
                    Tingkatkan <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">Kualitas</span> <br class="hidden sm:block">
                    Evaluasi Belajar.
                </h1>
                
                <!-- Description -->
                <p class="text-lg md:text-2xl text-gray-500 mb-12 max-w-3xl leading-relaxed font-medium">
                    Platform ujian sekolah digital super cepat dan aman untuk <strong class="text-gray-800 whitespace-nowrap">PKBM AL-QUDWAH</strong>. Menghadirkan pengalaman ujian tanpa hambatan bagi siswa dan guru.
                </p>
                
                <!-- Call to Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-8 py-4 rounded-full font-extrabold text-lg transition-all hover:bg-blue-700 hover:scale-105 hover:shadow-[0_0_40px_rgba(37,99,235,0.4)]">
                            Buka Dashboard Utama
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center bg-blue-600 text-white px-10 py-4 rounded-full font-extrabold text-lg transition-all hover:bg-blue-700 hover:scale-105 shadow-xl hover:shadow-[0_0_40px_rgba(37,99,235,0.4)]">
                            Mulai Login Aplikasi
                        </a>
                        <a href="#fitur" class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-gray-800 border border-gray-200 px-8 py-4 rounded-full font-bold text-lg transition-all hover:bg-gray-50 hover:shadow-lg">
                            Pelajari Fitur
                        </a>
                    @endauth
                @endif
                </div>

            </div>
        </main>

        <!-- Feature Section -->
        <section id="fitur" class="py-24 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Dirancang Untuk Efisiensi</h2>
                    <p class="text-gray-500 mt-4 text-lg">Semua yang Anda butuhkan untuk menyelenggarakan ujian berstandar tinggi.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Waktu</h3>
                        <p class="text-gray-500 leading-relaxed">Timer presisi yang tersinkronisasi di sisi server. Memastikan ujian selesai tepat waktu tanpa kecurangan.</p>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Autosave Real-time</h3>
                        <p class="text-gray-500 leading-relaxed">Setiap detik dan setiap klik jawaban otomatis tersimpan. Siswa tidak perlu khawatir jika koneksi terputus.</p>
                    </div>
                    
                    <!-- Card 3 -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Nilai Otomatis</h3>
                        <p class="text-gray-500 leading-relaxed">Sistem langsung melakukan kalkulasi rekap nilai dan statistik ujian seketika setelah ujian berakhir.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-10 relative z-10">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-md">
                    <span class="font-bold text-gray-900 whitespace-nowrap">PKBM AL-QUDWAH</span>
                </div>
                <p class="text-gray-500 text-sm font-medium">
                    &copy; {{ date('Y') }} Hak Cipta Dilindungi. Sistem Ujian Modern.
                </p>
            </div>
        </footer>
    </body>
</html>
