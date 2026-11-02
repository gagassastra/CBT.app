<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 rounded-3xl shadow-xl border border-indigo-500/20 p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Selamat Datang, {{ Auth::user()->name }}</h1>
                <p class="text-sm text-blue-200/85 mt-1">Anda telah berhasil masuk ke sistem CBT PKBM AL-QUDWAH.</p>
            </div>
            <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="ui-btn-primary shrink-0">
                Buka Panel Utama
            </a>
        </div>
    </div>
</x-app-layout>
