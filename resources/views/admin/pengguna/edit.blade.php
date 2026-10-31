<x-app-layout>
    <x-form-card
        title="Perbarui Data Pengguna"
        subtitle="Ubah informasi profil, alamat email, kata sandi, atau hak akses pengguna."
        :back="route('admin.pengguna.index')"
        :action="route('admin.pengguna.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan"
    >
        <x-field label="Nama Lengkap" name="name" :full="true" :required="true">
            <input type="text" id="name" name="name" value="{{ old('name', $data->name) }}" required autofocus class="ui-input">
        </x-field>

        <x-field label="Alamat Email" name="email" :required="true">
            <input type="email" id="email" name="email" value="{{ old('email', $data->email) }}" required class="ui-input">
        </x-field>

        <x-field label="Peran / Hak Akses" name="role" :required="true">
            <select id="role" name="role" class="ui-select">
                <option value="admin" {{ old('role', $data->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="guru" {{ old('role', $data->role) === 'guru' ? 'selected' : '' }}>Guru Pengajar</option>
            </select>
        </x-field>

        <x-field label="Kata Sandi Baru" name="password" :full="true" hint="Kosongkan apabila Anda tidak ingin mengubah kata sandi pengguna ini.">
            <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah..." class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
