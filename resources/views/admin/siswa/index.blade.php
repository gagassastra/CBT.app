<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">
                    <span>Data Master</span>
                    <span>&bull;</span>
                    <span>Peserta Didik</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Data Siswa</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola data peserta ujian, impor massal via CSV, dan cetak kartu peserta ujian sekolah.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.siswa.export') }}" class="ui-btn-secondary text-xs sm:text-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Template CSV
                </a>

                <a href="{{ route('admin.siswa.kartu_semua') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-sm shadow-emerald-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Semua Kartu
                </a>

                <a href="{{ route('admin.siswa.create') }}" class="ui-btn-primary text-xs sm:text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl flex items-center gap-3 shadow-2xs text-sm font-semibold">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Search & CSV Import Toolbar -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-xs border border-slate-200/80 flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
            <!-- Live Search -->
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex flex-1 gap-2" onsubmit="event.preventDefault();">
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="ui-input pl-10" oninput="searchSiswa(this.value)">
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.siswa.index') }}" class="ui-btn-ghost px-3.5 py-2 text-xs">Reset</a>
                @endif
            </form>

            <!-- Import CSV Box -->
            <div class="flex flex-wrap sm:flex-nowrap items-center justify-between lg:justify-end gap-3 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 bg-slate-50 border border-slate-200/90 px-3 py-1.5 rounded-xl">
                    @csrf
                    <input type="file" name="file" accept=".csv" required class="text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer max-w-[190px]">
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition shrink-0">
                        Import CSV
                    </button>
                </form>

                <div class="px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100 shrink-0" id="total-siswa">
                    Total: {{ $data->count() }} Siswa
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden" id="table-container">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/80 text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">NISN (Username)</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($data as $row)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 border border-blue-100 font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($row->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $row->name }}</div>
                                            @if($row->tempat_lahir || $row->tanggal_lahir)
                                                <div class="text-xs text-slate-400">
                                                    {{ $row->tempat_lahir ?? '-' }}{{ $row->tanggal_lahir ? ', ' . \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y') : '' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200">
                                        {{ $row->nisn ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($row->kelas)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $row->kelas->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Belum ada kelas</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.siswa.kartu', $row->id) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-100 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            Cetak Kartu
                                        </a>
                                        <a href="{{ route('admin.siswa.edit', $row->id) }}" class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 hover:bg-blue-50 hover:text-blue-700 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.siswa.destroy', $row->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center bg-red-50 text-red-600 hover:bg-red-100 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center text-slate-500">
                                    <p class="text-sm font-bold text-slate-700">Belum ada data siswa yang ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Tambahkan siswa secara manual atau unggah menggunakan file CSV.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let debounceTimer;
        function searchSiswa(query) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetch('{{ route('admin.siswa.index') }}?search=' + encodeURIComponent(query))
                    .then(res => res.text())
                    .then(html => {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');
                        document.querySelector('#table-container').innerHTML = doc.querySelector('#table-container').innerHTML;
                        document.querySelector('#total-siswa').innerHTML = doc.querySelector('#total-siswa').innerHTML;

                        let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(query);
                        if(query === '') {
                            newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                        }
                        window.history.pushState({path:newUrl}, '', newUrl);
                    });
            }, 300);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('searchInput');
            if(input && input.value) {
                const val = input.value;
                input.focus();
                input.value = '';
                input.value = val;
            }
        });
    </script>
</x-app-layout>
