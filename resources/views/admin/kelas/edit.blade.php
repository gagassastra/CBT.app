<x-app-layout>
    <x-form-card
        title="Perbarui Data Kelas"
        subtitle="Ubah informasi nama kelas yang terdaftar pada sistem."
        :back="route('admin.kelas.index')"
        :action="route('admin.kelas.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan"
    >
        <x-field label="Nama Kelas" name="nama_kelas" :full="true" :required="true">
            <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $data->nama_kelas) }}" required autofocus placeholder="Masukkan nama kelas..." class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
