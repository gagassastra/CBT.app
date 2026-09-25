<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Laporan Hasil Nilai Siswa</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Daftar Ujian Anda</h3>
                    <p class="text-sm text-slate-500 mt-1">Pilih ujian untuk melihat dan mencetak rekap nilai siswa.</p>
                </div>
            </div>
            
            <div class="overflow-x-auto p-4">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold rounded-tl-xl">Nama Ujian</th>
                            <th class="px-6 py-4 font-semibold">Mapel</th>
                            <th class="px-6 py-4 font-semibold">Kelas</th>
                            <th class="px-6 py-4 font-semibold rounded-tr-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                            <tr class="hover:bg-slate-50 transition border-b border-slate-100/80 last:border-0">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $row->nama_ujian }}</td>
                                <td class="px-6 py-4">{{ $row->mataPelajaran->nama_pelajaran ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $row->kelas->nama_kelas ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('guru.laporan.show', $row->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-xl font-semibold transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada ujian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


