<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-teal-500 to-emerald-600 rounded-3xl p-8 sm:p-10 text-white shadow-xl shadow-teal-900/20 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold mb-2">Selamat Datang, Guru! &#x1F44B; </h2>
                    <p class="text-teal-50 text-lg max-w-2xl">Pantau jadwal ujian, buat soal baru, dan evaluasi hasil belajar siswa Anda dengan mudah dan terpusat.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            @php
                $ujian = \App\Models\Ujian::where('guru_id', auth()->id())->count();
                $soal = \App\Models\Soal::whereHas('ujian', function($q){ $q->where('guru_id', auth()->id()); })->count();
                $ujian_aktif = \App\Models\Ujian::where('guru_id', auth()->id())->where('status', 'berlangsung')->count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Ujian Anda</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $ujian }}</h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Soal Dibuat</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $soal }}</h3>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Ujian Berlangsung</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $ujian_aktif }}</h3>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100 mt-6 flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Mulai Buat Ujian Baru?</h3>
                    <p class="text-slate-500 mt-1">Siapkan soal ujian untuk kelas Anda sekarang.</p>
                </div>
                <a href="{{ route('guru.ujian.create') }}" class="w-full sm:w-auto mt-6 sm:mt-0 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-bold transition shadow-lg shadow-teal-500/30">
                    Buat Ujian &rarr;
                </a>
            </div>

        </div>
    </div>
</x-app-layout>



