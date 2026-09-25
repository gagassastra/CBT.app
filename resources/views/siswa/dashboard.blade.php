<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 rounded-3xl p-8 sm:p-12 text-white shadow-2xl shadow-indigo-500/20 relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-32 -mb-10 w-40 h-40 bg-pink-500 opacity-20 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-sm font-medium mb-6">
                        <span class="flex w-2 h-2 rounded-full bg-green-400 mr-2"></span> Sistem Aktif
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-4 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-indigo-100 text-lg max-w-2xl font-medium leading-relaxed">
                        Selamat datang di portal evaluasi pembelajaran. Persiapkan diri Anda dan kerjakan ujian dengan maksimal.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            @php
                $now = now();
                $ujian_tersedia = \App\Models\Ujian::where('kelas_id', auth()->user()->kelas_id)
                    ->where('waktu_mulai', '<=', $now)
                    ->where('waktu_selesai', '>=', $now)
                    ->count();
                $ujian_selesai = \App\Models\HasilUjian::whereHas('pesertaUjian', function($q) { $q->where('siswa_id', auth()->id()); })->count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Active Exams -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-100 flex flex-col sm:flex-row items-center sm:space-x-6 space-y-4 sm:space-y-0 text-center sm:text-left hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 font-semibold tracking-wide uppercase text-sm">Ujian Tersedia</p>
                        <h3 class="text-4xl font-extrabold text-slate-900 mt-1">{{ $ujian_tersedia }} <span class="text-base font-medium text-slate-500">Ujian</span></h3>
                    </div>
                </div>

                <!-- Completed Exams -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/40 border border-slate-100 flex flex-col sm:flex-row items-center sm:space-x-6 space-y-4 sm:space-y-0 text-center sm:text-left hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 font-semibold tracking-wide uppercase text-sm">Diselesaikan</p>
                        <h3 class="text-4xl font-extrabold text-slate-900 mt-1">{{ $ujian_selesai }} <span class="text-base font-medium text-slate-500">Ujian</span></h3>
                    </div>
                </div>
            </div>

            <!-- Action Card -->
            <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/40 border border-slate-100 flex flex-col md:flex-row justify-between items-center text-center md:text-left relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-indigo-50 to-transparent z-0 hidden md:block"></div>
                <div class="relative z-10 mb-6 md:mb-0">
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Siap Memulai Ujian?</h3>
                    <p class="text-slate-500 mt-2 text-lg">Cek daftar ujian yang aktif untuk kelas Anda saat ini.</p>
                </div>
                <div class="relative z-10 w-full md:w-auto">
                    <a href="{{ route('siswa.ujian.index') }}" class="inline-flex justify-center items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold transition-all duration-200 shadow-lg shadow-indigo-500/30 w-full md:w-auto text-lg group">
                        Lihat Daftar Ujian 
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>



