<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 text-white border-b border-indigo-400/20 shadow-lg shadow-indigo-950/15">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6 lg:gap-8">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center gap-3 group">
                    <div class="p-1 rounded-xl bg-white/10 border border-white/20 shadow-sm group-hover:bg-white/20 transition">
                        <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-8 w-8 rounded-lg object-contain bg-white p-0.5">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm sm:text-base font-extrabold text-white tracking-tight leading-none">PKBM AL-QUDWAH</span>
                        <span class="text-[11px] font-semibold text-cyan-300 tracking-wide mt-0.5">Portal Ujian CBT</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex md:items-center md:gap-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                        <svg class="w-4 h-4 mr-1.5 opacity-85" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.kelas.index')" :active="request()->routeIs('admin.kelas.*')">
                            Kelas
                        </x-nav-link>
                        <x-nav-link :href="route('admin.mapel.index')" :active="request()->routeIs('admin.mapel.*')">
                            Mapel
                        </x-nav-link>
                        <x-nav-link :href="route('admin.tahun_ajaran.index')" :active="request()->routeIs('admin.tahun_ajaran.*')">
                            Tahun Ajaran
                        </x-nav-link>
                        <x-nav-link :href="route('admin.siswa.index')" :active="request()->routeIs('admin.siswa.*')">
                            Siswa
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pengguna.index')" :active="request()->routeIs('admin.pengguna.*')">
                            Pengguna
                        </x-nav-link>
                        <x-nav-link :href="route('admin.ujian.index')" :active="request()->routeIs('admin.ujian.*')">
                            Ujian
                        </x-nav-link>
                        <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">
                            Laporan
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'guru')
                        <x-nav-link :href="route('guru.ujian.index')" :active="request()->routeIs('guru.ujian.*')">
                            <svg class="w-4 h-4 mr-1.5 opacity-85" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            {{ __('Kelola Ujian') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guru.laporan.index')" :active="request()->routeIs('guru.laporan.*')">
                            <svg class="w-4 h-4 mr-1.5 opacity-85" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ __('Laporan Hasil') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'siswa')
                        <x-nav-link :href="route('siswa.ujian.index')" :active="request()->routeIs('siswa.ujian.*')">
                            <svg class="w-4 h-4 mr-1.5 opacity-85" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Daftar Ujian
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-4">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-full border border-white/15 bg-white/10 hover:bg-white/20 text-sm font-semibold text-white transition focus:outline-none focus:ring-2 focus:ring-cyan-400/40 backdrop-blur-sm">
                            <span class="w-7 h-7 rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 text-white text-xs font-extrabold flex items-center justify-center shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[140px] truncate">{{ Auth::user()->name }}</span>
                            <span class="hidden lg:inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-400/20 text-amber-200 border border-amber-300/30">
                                {{ Auth::user()->role }}
                            </span>
                            <svg class="h-4 w-4 text-blue-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-indigo-100 bg-gradient-to-r from-indigo-50/80 to-blue-50/50">
                            <p class="text-[11px] font-bold text-indigo-500 uppercase tracking-wider">Masuk sebagai</p>
                            <p class="text-sm font-extrabold text-slate-900 truncate mt-0.5">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? Auth::user()->nisn }}</p>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ __('Pengaturan Profil') }}
                            </x-dropdown-link>
                        </div>

                        <!-- Authentication -->
                        <div class="border-t border-slate-100 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-2 text-red-600 hover:bg-red-50 hover:text-red-700 font-semibold">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    {{ __('Keluar Sistem') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-blue-100 bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-slate-900/95 backdrop-blur-md border-b border-indigo-400/20 shadow-xl"
         style="display: none;">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.kelas.index')" :active="request()->routeIs('admin.kelas.*')">Kelas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.mapel.index')" :active="request()->routeIs('admin.mapel.*')">Mata Pelajaran</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tahun_ajaran.index')" :active="request()->routeIs('admin.tahun_ajaran.*')">Tahun Ajaran</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.siswa.index')" :active="request()->routeIs('admin.siswa.*')">Data Siswa</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pengguna.index')" :active="request()->routeIs('admin.pengguna.*')">Data Pengguna</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.ujian.index')" :active="request()->routeIs('admin.ujian.*')">Kelola Ujian</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">Laporan Hasil</x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'guru')
                <x-responsive-nav-link :href="route('guru.ujian.index')" :active="request()->routeIs('guru.ujian.*')">
                    {{ __('Kelola Ujian') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guru.laporan.index')" :active="request()->routeIs('guru.laporan.*')">
                    {{ __('Laporan Hasil') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'siswa')
                <x-responsive-nav-link :href="route('siswa.ujian.index')" :active="request()->routeIs('siswa.ujian.*')">Daftar Ujian</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-indigo-400/20 bg-indigo-950/60">
            <div class="px-5 flex items-center mb-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center text-white font-bold text-base mr-3 shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs text-blue-200/80">{{ Auth::user()->email ?? Auth::user()->nisn }}</div>
                </div>
            </div>

            <div class="space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Pengaturan Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-rose-300 hover:text-white hover:bg-rose-500/20">
                        {{ __('Keluar Sistem') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
