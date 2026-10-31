<x-app-layout>
    <x-form-card
        title="Perbarui Mata Pelajaran"
        subtitle="Ubah nama mata pelajaran yang sudah terdaftar di sistem."
        :back="route('admin.mapel.index')"
        :action="route('admin.mapel.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan"
    >
        <x-field label="Nama Mata Pelajaran" name="nama_pelajaran" :full="true" :required="true">
            <input type="text" id="nama_pelajaran" name="nama_pelajaran" value="{{ old('nama_pelajaran', $data->nama_pelajaran) }}" required autofocus placeholder="Masukkan nama mata pelajaran..." class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
