<section>
    <header>
        <h2 class="text-lg font-extrabold text-slate-900">
            Informasi Profil {{ in_array($user->role, ['admin', 'guru']) ? '& Foto' : '' }}
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Perbarui informasi nama lengkap{{ in_array($user->role, ['admin', 'guru']) ? ', foto profil,' : '' }} dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        @if (in_array($user->role, ['admin', 'guru']))
            <div>
                <x-input-label for="foto" value="Foto Profil" />
                <div class="mt-1.5 flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100">
                    <div class="relative w-20 h-20 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-extrabold text-2xl flex items-center justify-center shadow-sm border-2 border-white shrink-0">
                        @if($user->foto_url)
                            <img id="profile-foto-preview" src="{{ $user->foto_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            <span id="profile-foto-placeholder" class="hidden">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @else
                            <img id="profile-foto-preview" src="" alt="{{ $user->name }}" class="w-full h-full object-cover hidden">
                            <span id="profile-foto-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="flex-1 space-y-2">
                        <input
                            type="file"
                            id="foto"
                            name="foto"
                            accept="image/jpeg,image/png,image/webp"
                            onchange="previewFotoProfilPribadi(this)"
                            class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer"
                        >
                        <p class="text-xs text-slate-500">Format: JPG, PNG, atau WebP (Maksimal 2 MB).</p>
                        @if($user->foto_url)
                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-rose-600 cursor-pointer">
                                <input type="checkbox" name="hapus_foto" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                                Hapus foto profil saat ini
                            </label>
                        @endif
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            </div>

            <script>
                function previewFotoProfilPribadi(input) {
                    const preview = document.getElementById('profile-foto-preview');
                    const placeholder = document.getElementById('profile-foto-placeholder');
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                            if (placeholder) placeholder.classList.add('hidden');
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
        @endif

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-xs text-slate-600">
                        Alamat email Anda belum diverifikasi.
                        <button form="send-verification" class="underline font-semibold text-blue-600 hover:text-blue-700">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-xs text-emerald-600">
                            Tautan verifikasi baru telah dikirimkan ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-1">
            <x-primary-button>Simpan Perubahan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-semibold text-emerald-600"
                >Berhasil disimpan.</p>
            @endif
        </div>
    </form>
</section>
