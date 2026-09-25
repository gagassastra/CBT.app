<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Data Siswa</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Kelola Akun Siswa</h1>
                <p class="text-blue-100 mt-1 text-sm">Kelola seluruh data siswa yang terdaftar di PKBM AL-QUDWAH.</p>
                @if(session('success'))
                    <p class="text-green-600 font-bold text-sm mt-2">{{ session('success') }}</p>
                @endif
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap sm:flex-nowrap items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">
                    @csrf
                    <input type="file" name="file" accept=".csv" required class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer w-48">
                    <button type="submit" class="bg-blue-100 text-blue-700 hover:bg-blue-200 font-bold py-1.5 px-3 rounded-md text-xs transition">Import CSV</button>
                </form>

                <a href="{{ route('admin.siswa.export') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-lg shadow-sm transition duration-200 ease-in-out flex items-center border border-slate-200">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Template
                </a>

                <a href="{{ route('admin.siswa.kartu_semua') }}" target="_blank" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5 transition-all duration-200 ease-in-out flex items-center border border-emerald-400/50">
                    <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Semua Kartu
                </a>
                
                <a href="{{ route('admin.siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition duration-200 ease-in-out flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50/50 text-slate-500 text-xs tracking-wider uppercase text-xs font-bold tracking-wider border-b border-slate-100/80">
                        <tr>
                            <th class="px-6 py-4">Nama Siswa</th>
                            <th class="px-6 py-4">NISN</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($data as $row)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 font-bold text-gray-900 text-base">{{ $row->name }}</td>
                            <td class="px-6 py-4">{{ $row->nisn ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($row->kelas)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $row->kelas->nama_kelas }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic text-xs">Belum ada kelas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.siswa.kartu', $row->id) }}" target="_blank" class="inline-flex items-center bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-medium px-3 py-1.5 rounded-md text-xs transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Cetak Kartu
                                </a>
                                <a href="{{ route('admin.siswa.edit', $row->id) }}" class="inline-flex items-center bg-yellow-50 text-yellow-700 hover:bg-yellow-100 font-medium px-3 py-1.5 rounded-md text-xs transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="inline-flex items-center bg-red-50 text-red-700 hover:bg-red-100 font-medium px-3 py-1.5 rounded-md text-xs transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada siswa yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


