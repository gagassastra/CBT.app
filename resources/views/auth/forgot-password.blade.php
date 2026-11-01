<x-guest-layout>
    <div class="mb-6">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 mb-3">
            Pemulihan Akses
        </span>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Lupa Kata Sandi?</h2>
        <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
            Masukkan alamat email yang terdaftar pada akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email Akun')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                Tautan untuk membuat kata sandi baru akan dikirim ke <strong>pesan email</strong> tersebut. Siswa yang belum memiliki email silakan menghubungi administrator sekolah.
            </p>
        </div>

        <div class="flex flex-col gap-3 pt-2">
            <button type="submit" class="w-full ui-btn-primary py-3">
                Kirim Tautan Reset Kata Sandi
            </button>
            <a href="{{ route('login') }}" class="w-full ui-btn-secondary py-2.5">
                &larr; Kembali ke Halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>
