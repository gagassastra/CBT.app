<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="scrolled ? 'bg-blue-700/95 shadow-lg backdrop-blur-md border-transparent' : 'bg-transparent border-white/10 backdrop-blur-sm'"
     class="border-b sticky top-0 z-50 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                                <!-- Logo -->
                <div class="shrink-0 flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="bg-white p-1 rounded-md shadow-sm">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo PKBM AL-QUDWAH" class="h-8 w-auto object-contain">
                        </div>
                        <span class="text-lg sm:text-xl font-extrabold text-white tracking-tight drop-shadow-md">PKBM AL-QUDWAH</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.kelas.index')" :active="request()->routeIs('admin.kelas.*')">Kelas</x-nav-link>
                        <x-nav-link :href="route('admin.mapel.index')" :active="request()->routeIs('admin.mapel.*')">Mapel</x-nav-link>
                        <x-nav-link :href="route('admin.tahun_ajaran.index')" :active="request()->routeIs('admin.tahun_ajaran.*')">Tahun Ajaran</x-nav-link>
                        <x-nav-link :href="route('admin.siswa.index')" :active="request()->routeIs('admin.siswa.*')">Data Siswa</x-nav-link>
                        <x-nav-link :href="route('admin.pengguna.index')" :active="request()->routeIs('admin.pengguna.*')">Data Pengguna</x-nav-link>
                    @endif
                    <!-- Guru Links -->
                    @if(Auth::user()->role === 'guru')
                        <x-nav-link :href="route('guru.ujian.index')" :active="request()->routeIs('guru.ujian.*')">
                            {{ __('Kelola Ujian') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guru.laporan.index')" :active="request()->routeIs('guru.laporan.*')">
                            {{ __('Laporan Hasil') }}
                        </x-nav-link>
                    @endif
                    @if(Auth::user()->role === 'siswa')
                        <x-nav-link :href="route('siswa.ujian.index')" :active="request()->routeIs('siswa.ujian.*')">Daftar Ujian</x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-white/10 hover:bg-white/20 hover:text-white focus:outline-none transition ease-in-out duration-150 backdrop-blur-sm">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-xl text-white bg-white/10 border border-white/20 shadow-sm hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/40 transition-all duration-200 ease-in-out backdrop-blur-sm">
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
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="sm:hidden absolute w-full bg-white/95 backdrop-blur-xl border-b border-slate-200 shadow-xl z-50 left-0" 
         style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.kelas.index')" :active="request()->routeIs('admin.kelas.*')">Kelas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.mapel.index')" :active="request()->routeIs('admin.mapel.*')">Mapel</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.tahun_ajaran.index')" :active="request()->routeIs('admin.tahun_ajaran.*')">Tahun Ajaran</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.siswa.index')" :active="request()->routeIs('admin.siswa.*')">Data Siswa</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pengguna.index')" :active="request()->routeIs('admin.pengguna.*')">Data Pengguna</x-responsive-nav-link>
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
        <div class="pt-4 pb-4 border-t border-slate-200/60 bg-slate-50/50 mt-2">
            <div class="px-5 flex items-center mb-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg mr-3 shadow-sm border border-blue-200">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-base text-slate-800 tracking-tight">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-red-600 hover:text-red-700 hover:bg-red-50 hover:border-red-100">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>



