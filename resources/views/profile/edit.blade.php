<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-2">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Pengaturan Profil</h1>
                <p class="text-blue-100 text-sm mt-1">Kelola informasi pribadi, alamat email, dan kata sandi akun Anda.</p>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <div class="p-6 sm:p-10 bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-6 sm:p-10 bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-6 sm:p-10 bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>



