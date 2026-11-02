<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Executive Welcome Banner -->
        <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden border border-slate-800">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 left-1/3 w-72 h-72 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

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
                            Panel Administrator Utama
                        </div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h1>
                        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mt-2 leading-relaxed">
                            Kelola seluruh data master akademik, akun siswa & guru, jadwal ujian, hingga laporan nilai akhir PKBM AL-QUDWAH secara terpusat.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="{{ route('admin.ujian.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold shadow-lg shadow-blue-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Buat Ujian Baru
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-semibold border border-white/15 backdrop-blur-sm transition">
                        Lihat Laporan Nilai
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        @php
            $siswa = \App\Models\User::where('role', 'siswa')->count();
            $guru = \App\Models\User::where('role', 'guru')->count();
            $kelas = \App\Models\Kelas::count();
            $ujian = \App\Models\Ujian::count();
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Siswa -->
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-6 text-white shadow-lg shadow-blue-600/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-100">Total Siswa</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $siswa }}</h3>
                    <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center text-xs font-bold text-cyan-200 hover:text-white mt-2.5">
                        Kelola Siswa &rarr;
                    </a>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0 shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-800 rounded-2xl p-6 text-white shadow-lg shadow-indigo-600/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-100">Total Guru</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $guru }}</h3>
                    <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center text-xs font-bold text-purple-200 hover:text-white mt-2.5">
                        Kelola Pengguna &rarr;
                    </a>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0 shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            <!-- Total Kelas -->
            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-800 rounded-2xl p-6 text-white shadow-lg shadow-emerald-600/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-100">Total Kelas</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $kelas }}</h3>
                    <a href="{{ route('admin.kelas.index') }}" class="inline-flex items-center text-xs font-bold text-teal-100 hover:text-white mt-2.5">
                        Daftar Kelas &rarr;
                    </a>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0 shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>

            <!-- Total Ujian -->
            <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-500 to-rose-600 rounded-2xl p-6 text-white shadow-lg shadow-orange-500/20 flex items-center justify-between hover:-translate-y-0.5 hover:shadow-xl transition duration-200">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="relative z-10">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-100">Total Ujian</p>
                    <h3 class="text-3xl font-extrabold text-white mt-1">{{ $ujian }}</h3>
                    <a href="{{ route('admin.ujian.index') }}" class="inline-flex items-center text-xs font-bold text-amber-100 hover:text-white mt-2.5">
                        Kelola Ujian &rarr;
                    </a>
                </div>
                <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md text-white border border-white/20 flex items-center justify-center shrink-0 shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
        </div>

        <!-- Quick Access Modules -->
        <div class="bg-gradient-to-br from-white via-indigo-50/30 to-blue-50/40 rounded-2xl p-6 sm:p-8 shadow-sm border border-indigo-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Modul Manajemen Cepat</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Akses langsung ke menu pengelolaan data master dan pelaksanaan ujian.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.siswa.index') }}" class="group p-4 rounded-xl border border-blue-200/80 bg-gradient-to-br from-blue-50/80 to-white hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 flex items-center gap-3.5 shadow-2xs hover:shadow-md">
                    <div class="w-11 h-11 rounded-xl bg-blue-600 text-white group-hover:bg-white/20 flex items-center justify-center shadow-sm shrink-0 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-900 group-hover:text-white transition">Data Siswa & Kartu</p>
                        <p class="text-xs text-slate-500 group-hover:text-blue-100 transition">Import CSV & cetak kartu</p>
                    </div>
                </a>

                <a href="{{ route('admin.mapel.index') }}" class="group p-4 rounded-xl border border-violet-200/80 bg-gradient-to-br from-violet-50/80 to-white hover:from-violet-600 hover:to-purple-700 transition-all duration-200 flex items-center gap-3.5 shadow-2xs hover:shadow-md">
                    <div class="w-11 h-11 rounded-xl bg-violet-600 text-white group-hover:bg-white/20 flex items-center justify-center shadow-sm shrink-0 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-900 group-hover:text-white transition">Mata Pelajaran</p>
                        <p class="text-xs text-slate-500 group-hover:text-violet-100 transition">Kelola daftar mapel</p>
                    </div>
                </a>

                <a href="{{ route('admin.tahun_ajaran.index') }}" class="group p-4 rounded-xl border border-emerald-200/80 bg-gradient-to-br from-emerald-50/80 to-white hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 flex items-center gap-3.5 shadow-2xs hover:shadow-md">
                    <div class="w-11 h-11 rounded-xl bg-emerald-600 text-white group-hover:bg-white/20 flex items-center justify-center shadow-sm shrink-0 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-900 group-hover:text-white transition">Tahun Ajaran</p>
                        <p class="text-xs text-slate-500 group-hover:text-emerald-100 transition">Atur periode aktif</p>
                    </div>
                </a>

                <a href="{{ route('admin.ujian.index') }}" class="group p-4 rounded-xl border border-amber-200/80 bg-gradient-to-br from-amber-50/80 to-white hover:from-amber-500 hover:to-orange-600 transition-all duration-200 flex items-center gap-3.5 shadow-2xs hover:shadow-md">
                    <div class="w-11 h-11 rounded-xl bg-amber-500 text-white group-hover:bg-white/20 flex items-center justify-center shadow-sm shrink-0 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-900 group-hover:text-white transition">Ujian & Bank Soal</p>
                        <p class="text-xs text-slate-500 group-hover:text-amber-100 transition">Jadwal & butir soal</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Status Pembuatan Soal oleh Guru -->
        @php
            $dataGuru = \App\Models\User::where('role', 'guru')->get()->map(function($guru) {
                $guru->total_ujian = \App\Models\Ujian::where('guru_id', $guru->id)->count();
                $guru->total_soal = \App\Models\Soal::whereHas('ujian', function($q) use ($guru) {
                    $q->where('guru_id', $guru->id);
                })->count();
                return $guru;
            });
        @endphp
        <div class="bg-white rounded-2xl shadow-md shadow-indigo-950/5 border border-indigo-100 overflow-hidden">
            <div class="px-6 sm:px-8 py-5 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-950 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-lg font-extrabold text-white">Monitoring Aktivitas Guru</h2>
                    <p class="text-xs sm:text-sm text-blue-200/80 mt-0.5">Rekapitulasi jumlah jadwal ujian dan butir soal yang telah disusun oleh masing-masing guru.</p>
                </div>
                <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold text-cyan-200 transition">
                    Lihat Semua Pengguna &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-indigo-100 text-sm">
                    <thead class="bg-indigo-50/70">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Nama Guru</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Alamat Email</th>
                            <th class="px-6 py-3.5 text-center text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Total Ujian</th>
                            <th class="px-6 py-3.5 text-center text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Status Bank Soal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-indigo-50">
                        @forelse($dataGuru as $guru)
                            <tr class="hover:bg-indigo-50/40 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($guru->foto_url)
                                            <img src="{{ $guru->foto_url }}" alt="{{ $guru->name }}" class="w-9 h-9 rounded-full object-cover border border-indigo-200 shadow-xs shrink-0">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-600 to-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                                {{ strtoupper(substr($guru->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="font-bold text-slate-800">{{ $guru->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $guru->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200/80 rounded-lg text-xs font-bold">
                                        {{ $guru->total_ujian }} Ujian
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($guru->total_soal > 0)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $guru->total_soal }} Butir Soal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Belum Membuat Soal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">Belum ada akun guru yang terdaftar di sistem.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
