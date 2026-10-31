<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Student Welcome Banner -->
        <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden border border-slate-800">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-blue-200 mb-4">
                        <span class="flex w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Portal Peserta Ujian CBT
                    </div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">
                        Halo, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                        Selamat datang di portal evaluasi pembelajaran digital PKBM AL-QUDWAH. Pastikan koneksi Anda stabil dan kerjakan setiap ujian dengan teliti serta jujur.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('siswa.ujian.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold shadow-lg shadow-blue-600/30 transition">
                        Lihat Daftar Ujian
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Student Identity Card -->
            <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-200/80 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Identitas Peserta</p>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-1">NISN: {{ Auth::user()->nisn ?? '-' }}</h3>
                    <p class="text-xs font-semibold text-blue-600 mt-1">Kelas: {{ Auth::user()->kelas->nama_kelas ?? 'Belum ditentukan' }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                </div>
            </div>

            <!-- Active Exams -->
            <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-200/80 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Ujian Aktif Saat Ini</p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $ujian_tersedia }} <span class="text-sm font-semibold text-slate-500">Ujian</span></h3>
                    <p class="text-xs text-slate-500 mt-1">Siap untuk dikerjakan</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <!-- Completed Exams -->
            <div class="bg-white rounded-2xl p-6 shadow-xs border border-slate-200/80 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Ujian Diselesaikan</p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $ujian_selesai }} <span class="text-sm font-semibold text-slate-500">Ujian</span></h3>
                    <p class="text-xs text-slate-500 mt-1">Telah dikumpulkan</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Siap Memulai Evaluasi Pembelajaran?</h3>
                <p class="text-sm text-slate-500 mt-1">Periksa jadwal mata pelajaran yang sedang berlangsung untuk kelas Anda dan mulai kerjakan ujian.</p>
            </div>
            <a href="{{ route('siswa.ujian.index') }}" class="ui-btn-primary px-6 py-3 w-full sm:w-auto">
                Buka Daftar Ujian
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</x-app-layout>
