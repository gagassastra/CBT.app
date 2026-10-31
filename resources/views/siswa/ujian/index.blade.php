<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                    <span>Portal Evaluasi Siswa</span>
                    <span>&bull;</span>
                    <span>Kelas {{ Auth::user()->kelas->nama_kelas ?? '-' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Ujian Tersedia</h1>
                <p class="text-slate-500 text-sm mt-1">Pilih jadwal ujian yang sedang berlangsung dan pastikan Anda mengerjakan dengan jujur serta teliti.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl flex items-center gap-3 shadow-2xs text-sm font-semibold">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl flex items-center gap-3 shadow-2xs text-sm font-semibold">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($data as $row)
                @php
                    $peserta = \App\Models\PesertaUjian::where('ujian_id', $row->id)->where('siswa_id', auth()->id())->first();
                    $hasil = $peserta ? \App\Models\HasilUjian::where('peserta_ujian_id', $peserta->id)->first() : null;

                    $isSelesai = $peserta && $peserta->status == 'selesai';
                    $isMengerjakan = $peserta && $peserta->status == 'mengerjakan';
                    $statusAktif = $row->status_aktif;
                @endphp
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 flex flex-col overflow-hidden hover:shadow-md hover:border-blue-200 transition-all duration-200">
                    <!-- Card Body -->
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex justify-between items-start gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $row->mataPelajaran->nama_pelajaran ?? 'Mata Pelajaran' }}
                            </span>

                            @if($isSelesai)
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Selesai
                                </span>
                            @elseif($isMengerjakan)
                                <span class="bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Sedang Dikerjakan
                                </span>
                            @elseif($statusAktif == 'Aktif')
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Berlangsung
                                </span>
                            @else
                                <span class="bg-slate-100 text-slate-600 border border-slate-200 text-xs font-bold px-2.5 py-1 rounded-full">
                                    {{ $statusAktif }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-extrabold text-slate-900 leading-snug mb-1">{{ $row->nama_ujian }}</h3>
                        <p class="text-xs font-medium text-slate-500 mb-5">Pengajar: {{ $row->guru->name ?? 'Guru Mata Pelajaran' }}</p>

                        <div class="grid grid-cols-2 gap-3 mt-auto">
                            <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Durasi Waktu</span>
                                <span class="block text-sm font-extrabold text-slate-800 mt-0.5">{{ $row->durasi }} Menit</span>
                            </div>
                            <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                                <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Jumlah Soal</span>
                                <span class="block text-sm font-extrabold text-slate-800 mt-0.5">{{ $row->soals ? $row->soals->count() : 0 }} Butir</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="bg-slate-50/70 px-6 py-4 border-t border-slate-100">
                        @if($isSelesai)
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Nilai Akhir Anda</span>
                                    <span class="text-2xl font-extrabold text-blue-600">{{ $hasil ? number_format($hasil->nilai_akhir, 0) : 'N/A' }}</span>
                                </div>
                                @if($hasil)
                                    <div class="flex items-center justify-between text-xs font-bold mt-2.5 pt-2.5 border-t border-slate-200/70">
                                        <span class="text-emerald-600">Benar: {{ $hasil->jumlah_benar }}</span>
                                        <span class="text-red-500">Salah: {{ $hasil->jumlah_salah }}</span>
                                        <span class="text-slate-500">Kosong: {{ $hasil->tidak_dijawab }}</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            @if($statusAktif == 'Aktif')
                                <form action="{{ route('siswa.ujian.mulai', $row->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full ui-btn-primary py-3">
                                        {{ $isMengerjakan ? 'Lanjutkan Pengerjaan' : 'Mulai Kerjakan Ujian' }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </form>
                            @else
                                <div class="w-full text-center py-2.5 px-4 rounded-xl bg-slate-100 text-slate-500 text-xs font-bold border border-slate-200">
                                    {{ $statusAktif == 'Belum Mulai' ? 'Jadwal Ujian Belum Dimulai' : 'Waktu Ujian Telah Berakhir' }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-14 text-center shadow-xs border border-slate-200/80">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Jadwal Ujian</h3>
                    <p class="text-xs text-slate-500 mt-1">Saat ini belum ada ujian yang dijadwalkan untuk kelas Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
