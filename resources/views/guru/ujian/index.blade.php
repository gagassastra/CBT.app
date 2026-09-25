<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Kelola Daftar Ujian
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Add Button -->
        <div class="flex justify-between items-center flex-wrap gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Daftar Ujian</h1>
                <p class="text-blue-100 mt-1 text-sm">Kelola seluruh jadwal ujian beserta soal-soalnya di sini.</p>
            </div>
            <a href="{{ route('guru.ujian.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition duration-200 ease-in-out flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Buat Ujian Baru
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50/50 text-slate-500 text-xs tracking-wider uppercase text-xs font-bold tracking-wider border-b border-slate-100/80 border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama Ujian</th>
                            <th class="px-6 py-4">Informasi</th>
                            <th class="px-6 py-4">Jadwal & Durasi</th>
                            <th class="px-6 py-4 text-center">Soal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($data as $row)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-base">{{ $row->nama_ujian }}</div>
                                <div class="text-xs text-gray-500 mt-1">TA: {{ $row->tahunAjaran->tahun_ajaran ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-gray-700">
                                    <span class="font-medium bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded text-xs">{{ $row->mataPelajaran->nama_pelajaran ?? '-' }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Kelas: <strong>{{ $row->kelas->nama_kelas ?? '-' }}</strong></div>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div>Mulai: <span class="font-medium text-slate-800">{{ $row->waktu_mulai ? \Carbon\Carbon::parse($row->waktu_mulai)->format('d M Y, H:i') : '-' }}</span></div>
                                <div class="mt-1">Durasi: <span class="font-medium text-slate-800">{{ $row->durasi }} Menit</span></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">
                                    {{ $row->soals ? $row->soals->count() : 0 }} Soal
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($row->status_aktif == 'Aktif')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200 shadow-sm animate-pulse">Aktif</span>
                                @elseif($row->status_aktif == 'Belum Mulai')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200 shadow-sm">Belum Mulai</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-200 shadow-sm">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('guru.ujian.show', $row->id) }}" class="inline-flex items-center bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium px-3 py-1.5 rounded-md text-xs transition">
                                    Kelola Soal
                                </a>
                                <a href="{{ route('guru.ujian.edit', $row->id) }}" class="inline-flex items-center bg-yellow-50 text-yellow-700 hover:bg-yellow-100 font-medium px-3 py-1.5 rounded-md text-xs transition">
                                    Edit
                                </a>
                                <form action="{{ route('guru.ujian.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini? Seluruh soal dan nilai terkait akan hilang!');">
                                    @csrf 
                                    @method('DELETE')
                                    <button style="background-color: #ef4444; color: white;" class="inline-flex items-center hover:bg-red-600 font-bold px-3 py-1.5 rounded-md text-xs transition shadow-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Belum ada ujian yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


