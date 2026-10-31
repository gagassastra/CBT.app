<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-slate-500 mt-1">Anda telah berhasil masuk ke sistem CBT PKBM AL-QUDWAH.</p>
            </div>
            <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="ui-btn-primary">
                Buka Panel Utama
            </a>
        </div>
    </div>
</x-app-layout>
