<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 sm:p-10 text-white shadow-xl shadow-blue-900/20 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold mb-2">Selamat Datang, Admin! &#x1F44B; </h2>
                    <p class="text-blue-100 text-lg max-w-2xl">Kelola seluruh data master, pengguna, mata pelajaran, hingga konfigurasi sistem ujian PKBM AL-QUDWAH melalui panel kontrol ini.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            @php
                $siswa = \App\Models\User::where('role','siswa')->count();
                $guru = \App\Models\User::where('role','guru')->count();
                $kelas = \App\Models\Kelas::count();
                $ujian = \App\Models\Ujian::count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Siswa</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $siswa }}</h3>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Guru</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $guru }}</h3>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Kelas</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $kelas }}</h3>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-lg shadow-slate-200/50 border border-slate-100 flex items-center space-x-4 hover:-translate-y-1 transition-transform">
                    <div class="w-14 h-14 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Ujian</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $ujian }}</h3>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Akses Cepat</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.pengguna.index') }}" class="w-full sm:w-auto text-center px-6 py-3 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 rounded-xl font-semibold transition border border-slate-200">Kelola Pengguna</a>
                    <a href="{{ route('admin.kelas.index') }}" class="w-full sm:w-auto text-center px-6 py-3 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 rounded-xl font-semibold transition border border-slate-200">Kelola Kelas</a>
                    <a href="{{ route('admin.mapel.index') }}" class="w-full sm:w-auto text-center px-6 py-3 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 rounded-xl font-semibold transition border border-slate-200">Kelola Mapel</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>



