<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Lupa Password?</h2>
        <p class="text-sm text-slate-500 mt-2">
            Jangan khawatir! Masukkan alamat email Anda di bawah ini, dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Akun')" class="text-slate-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email terdaftar Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-6 flex flex-col space-y-3">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                Kirim Tautan Reset Password
            </button>
            <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-slate-300 rounded-lg shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition duration-150">
                Kembali ke Halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>
