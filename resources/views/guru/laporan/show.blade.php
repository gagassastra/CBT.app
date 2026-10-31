<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Back Link -->
        <div>
            <a href="{{ route(auth()->user()->role . '.laporan.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Laporan
            </a>
        </div>

        <!-- Exam Header & Export Action -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold">
                        {{ $ujian->mataPelajaran->nama_pelajaran ?? '-' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">
                        Kelas: {{ $ujian->kelas->nama_kelas ?? '-' }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $ujian->nama_ujian }}</h1>
                <p class="text-sm text-slate-500 mt-1">Rekapitulasi nilai akhir dan rincian jawaban peserta ujian.</p>
            </div>
            <a href="{{ route(auth()->user()->role . '.laporan.pdf', $ujian->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-red-600/20 transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Unduh / Cetak PDF
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl flex items-center gap-3 shadow-2xs text-sm font-semibold">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @php
            $adaEsai = $ujian->soals()->where('tipe', 'esai')->exists();
            $pesertaSelesai = $ujian->pesertaUjians->filter(fn($p) => $p->status == 'selesai' && $p->hasilUjian);
            $rataRata = $pesertaSelesai->count() > 0 ? $pesertaSelesai->avg(fn($p) => $p->hasilUjian->nilai_akhir) : 0;
            $nilaiTertinggi = $pesertaSelesai->count() > 0 ? $pesertaSelesai->max(fn($p) => $p->hasilUjian->nilai_akhir) : 0;
        @endphp

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Peserta Selesai</p>
                <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $pesertaSelesai->count() }} <span class="text-sm font-medium text-slate-500">Siswa</span></p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Rata-Rata Kelas</p>
                <p class="text-2xl font-extrabold text-blue-600 mt-1">{{ number_format($rataRata, 1) }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Nilai Tertinggi</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($nilaiTertinggi, 0) }}</p>
            </div>
        </div>

        <!-- Score Table -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/80 text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Benar</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Salah</th>
                            <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Kosong</th>
                            @if($adaEsai)
                                <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Koreksi Esai</th>
                            @endif
                            <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Nilai Akhir</th>
                            <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @php $no = 1; @endphp
                        @forelse($pesertaSelesai as $peserta)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-400 font-medium">{{ $no++ }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-900">{{ $peserta->siswa->name ?? 'Siswa' }}</div>
                                    <div class="text-xs text-slate-400">NISN: {{ $peserta->siswa->nisn ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 font-bold text-xs">{{ $peserta->hasilUjian->jumlah_benar }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 rounded-md bg-red-50 text-red-600 font-bold text-xs">{{ $peserta->hasilUjian->jumlah_salah }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 font-bold text-xs">{{ $peserta->hasilUjian->tidak_dijawab }}</span>
                                </td>
                                @if($adaEsai)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route(auth()->user()->role . '.laporan.koreksi', $peserta->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $peserta->hasilUjian->esai_belum_dinilai > 0 ? 'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' }}">
                                            {{ $peserta->hasilUjian->esai_belum_dinilai > 0 ? 'Koreksi (' . $peserta->hasilUjian->esai_belum_dinilai . ' Belum)' : 'Lihat / Ubah Skor' }}
                                        </a>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-lg font-extrabold text-blue-600">{{ number_format($peserta->hasilUjian->nilai_akhir, 0) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <form action="{{ route(auth()->user()->role . '.laporan.reset', $peserta->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mereset ujian siswa ini? Nilai dan seluruh jawaban siswa akan dihapus agar siswa dapat mengerjakan ulang.');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 font-bold rounded-lg text-xs transition">
                                            Reset Ujian
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $adaEsai ? 8 : 7 }}" class="px-6 py-14 text-center text-slate-500">
                                    <p class="text-sm font-bold text-slate-700">Belum ada peserta yang menyelesaikan ujian ini</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Nilai siswa akan otomatis tampil setelah mereka mengumpulkan ujian.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
