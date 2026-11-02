<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Page Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 rounded-2xl p-6 sm:p-8 shadow-lg shadow-indigo-950/10 border border-indigo-500/20 text-white flex items-center justify-between gap-4">
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold uppercase tracking-wider text-cyan-300 mb-2">
                    <span>Akun Pengguna</span>
                    <span>&bull;</span>
                    <span>Keamanan & Identitas</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Pengaturan Profil</h1>
                <p class="text-blue-100/80 text-sm mt-1">Kelola informasi pribadi, alamat email, dan pembaruan kata sandi akun Anda.</p>
            </div>
            <div class="relative z-10 hidden sm:flex w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 text-white font-extrabold text-xl items-center justify-center shadow-md border border-white/20 shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-6 sm:p-8 bg-gradient-to-b from-white to-indigo-50/30 rounded-2xl shadow-md shadow-indigo-950/5 border border-indigo-100 border-t-4 border-t-blue-600">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-gradient-to-b from-white to-indigo-50/30 rounded-2xl shadow-md shadow-indigo-950/5 border border-indigo-100 border-t-4 border-t-indigo-600">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-gradient-to-b from-white to-rose-50/30 rounded-2xl shadow-md shadow-rose-950/5 border border-rose-100 border-t-4 border-t-rose-600">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
