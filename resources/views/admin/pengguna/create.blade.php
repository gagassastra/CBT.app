<x-app-layout>
    <x-form-card
        title="Tambah Pengguna Baru"
        subtitle="Daftarkan akun Administrator atau Guru pengajar baru ke dalam sistem."
        :back="route('admin.pengguna.index')"
        :action="route('admin.pengguna.store')"
        submit="Simpan Pengguna"
    >
        <x-field label="Nama Lengkap" name="name" :full="true" :required="true">
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap beserta gelar..." class="ui-input">
        </x-field>

        <x-field label="Alamat Email" name="email" :required="true" hint="Digunakan sebagai username saat login.">
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@alqudwah.sch.id" class="ui-input">
        </x-field>

        <x-field label="Peran / Hak Akses" name="role" :required="true">
            <select id="role" name="role" class="ui-select">
                <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru Pengajar</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
        </x-field>

        <x-field label="Kata Sandi" name="password" :full="true" :required="true" hint="Minimal 6 karakter.">
            <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi..." class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
