<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Buat Password Baru</h2>
        <p class="text-sm text-slate-500 mt-2">
            Silakan masukkan email dan password baru Anda di bawah ini untuk memulihkan akses ke akun Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email Akun')" class="text-slate-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password Baru')" class="text-slate-700 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="text-slate-700 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                Simpan Password Baru
            </button>
        </div>
    </form>
</x-guest-layout>
