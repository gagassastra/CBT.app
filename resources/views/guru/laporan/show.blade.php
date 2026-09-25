<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Detail Nilai Ujian</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <div>
                <a href="{{ route('guru.laporan.index') }}" class="text-slate-500 hover:text-blue-600 text-sm font-semibold mb-2 inline-block">&larr; Kembali ke Daftar</a>
                <h1 class="text-3xl font-extrabold text-white">{{ $ujian->nama_ujian }}</h1>
                <p class="text-blue-100 mt-1">Kelas: {{ $ujian->kelas->nama_kelas ?? '-' }} | Mapel: {{ $ujian->mataPelajaran->nama_pelajaran ?? '-' }}</p>
            </div>
            <a href="{{ route('guru.laporan.pdf', $ujian->id) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Cetak PDF
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto p-4">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold rounded-tl-xl">No</th>
                            <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 font-semibold">Benar</th>
                            <th class="px-6 py-4 font-semibold">Salah</th>
                            <th class="px-6 py-4 font-semibold">Kosong</th>
                            <th class="px-6 py-4 font-semibold rounded-tr-xl">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ujian->pesertaUjians as $index => $peserta)
                            @if($peserta->status == 'selesai' && $peserta->hasilUjian)
                            <tr class="hover:bg-slate-50 transition border-b border-slate-100/80 last:border-0">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $peserta->siswa->name ?? 'Siswa' }}</td>
                                <td class="px-6 py-4 text-green-600 font-bold">{{ $peserta->hasilUjian->jumlah_benar }}</td>
                                <td class="px-6 py-4 text-red-600 font-bold">{{ $peserta->hasilUjian->jumlah_salah }}</td>
                                <td class="px-6 py-4 text-slate-400 font-bold">{{ $peserta->hasilUjian->tidak_dijawab }}</td>
                                <td class="px-6 py-4 text-blue-600 font-black text-lg">{{ number_format($peserta->hasilUjian->nilai_akhir, 0) }}</td>
                            </tr>
                            @endif
                        @empty
                            <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada siswa yang menyelesaikan ujian ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


