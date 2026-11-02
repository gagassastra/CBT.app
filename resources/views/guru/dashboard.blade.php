<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Teacher Welcome Banner -->
        <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden border border-slate-800">
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-start sm:items-center gap-5">
                    <a href="{{ route('profile.edit') }}" title="Ubah Foto Profil" class="hidden sm:flex shrink-0 group relative">
                        @if(Auth::user()->foto_url)
                            <img src="{{ Auth::user()->foto_url }}" alt="{{ Auth::user()->name }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-cyan-300/40 shadow-lg group-hover:scale-105 transition">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 text-white font-extrabold text-2xl flex items-center justify-center border-2 border-white/20 shadow-lg group-hover:scale-105 transition">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-blue-200 mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Panel Pengajar / Guru
                        </div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h1>
                        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                            Kelola jadwal ujian kelas Anda, susun butir soal pilihan ganda maupun esai, serta pantau dan cetak rekapitulasi nilai siswa.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="{{ route('guru.ujian.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold shadow-lg shadow-blue-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Buat Ujian Baru
                    </a>
                    <a href="{{ route('guru.laporan.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-semibold border border-white/15 transition">
                        Laporan Nilai Siswa
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        @php
            $ujian = \App\Models\Ujian::where('guru_id', auth()->id())->count();
            $soal = \App\Models\Soal::whereHas('ujian', function($q){ $q->where('guru_id', auth()->id()); })->count();
            $now = now();
            $ujian_aktif = \App\Models\Ujian::where('guru_id', auth()->id())
                ->where('waktu_mulai', '<=', $now)
                ->where('waktu_selesai', '>=', $now)
                ->count();
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-6 text-white shadow-lg shadow-blue-600/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-100">Total Ujian Anda</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $ujian }}</h3>
                    <p class="text-xs text-cyan-200 font-medium mt-1">Jadwal ujian terdaftar</p>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-800 rounded-2xl p-6 text-white shadow-lg shadow-indigo-600/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-100">Total Butir Soal</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $soal }}</h3>
                    <p class="text-xs text-purple-200 font-medium mt-1">Pilihan ganda & esai</p>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-800 rounded-2xl p-6 text-white shadow-lg shadow-emerald-600/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-100">Ujian Sedang Aktif</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $ujian_aktif }}</h3>
                    <p class="text-xs text-teal-100 font-medium mt-1">Berlangsung saat ini</p>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Call to Action Card -->
        <div class="bg-gradient-to-r from-white via-indigo-50/60 to-blue-100/60 rounded-2xl p-6 sm:p-8 shadow-md shadow-indigo-950/5 border border-indigo-200/80 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="flex items-start gap-4">
                <div class="hidden sm:flex w-13 h-13 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-md shadow-indigo-500/20 items-center justify-center shrink-0 p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Kelola Jadwal Ujian & Bank Soal</h3>
                    <p class="text-sm text-slate-600 mt-1">Susun soal baru dengan dukungan gambar/video atau periksa hasil pengerjaan ujian siswa.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                <a href="{{ route('guru.ujian.index') }}" class="ui-btn-secondary flex-1 sm:flex-initial">
                    Daftar Ujian
                </a>
                <a href="{{ route('guru.ujian.create') }}" class="ui-btn-primary flex-1 sm:flex-initial">
                    Buat Ujian Baru &rarr;
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
