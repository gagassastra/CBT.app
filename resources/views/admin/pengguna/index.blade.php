<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Page Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 rounded-2xl p-6 sm:p-8 shadow-lg shadow-indigo-950/10 border border-indigo-500/20 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold uppercase tracking-wider text-cyan-300 mb-2.5">
                    <span>Manajemen Akses</span>
                    <span>&bull;</span>
                    <span>Staf & Pengajar</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Data Pengguna Sistem</h1>
                <p class="text-blue-100/80 text-sm mt-1">Kelola akun Administrator dan Guru pengajar di lingkungan PKBM AL-QUDWAH.</p>
            </div>
            <a href="{{ route('admin.pengguna.create') }}" class="relative z-10 ui-btn-primary shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Pengguna
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl flex items-center gap-3 shadow-2xs text-sm font-semibold">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-md shadow-indigo-950/5 border border-indigo-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-indigo-100 bg-gradient-to-r from-indigo-50/90 via-blue-50/60 to-white flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-wider text-indigo-900">Daftar Akun Admin & Guru</span>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white shadow-2xs">Total: {{ $data->count() }} Akun</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-indigo-100">
                    <thead class="bg-indigo-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold text-indigo-950 uppercase tracking-wider w-16">No</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Alamat Email</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-extrabold text-indigo-950 uppercase tracking-wider">Hak Akses (Role)</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-extrabold text-indigo-950 uppercase tracking-wider w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($data as $index => $p)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($p->foto_url)
                                            <img src="{{ $p->foto_url }}" alt="{{ $p->name }}" class="h-10 w-10 rounded-full object-cover border-2 border-indigo-200 shadow-2xs shrink-0">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-2xs shrink-0">
                                                {{ strtoupper(substr($p->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="text-sm font-bold text-slate-800">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-600">{{ $p->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($p->role === 'admin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            Administrator
                                        </span>
                                    @elseif($p->role === 'guru')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Guru Pengajar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ ucfirst($p->role) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.pengguna.edit', $p->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 text-xs font-bold transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pengguna.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 text-xs font-bold transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center text-slate-500">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-700">Belum ada data pengguna</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
