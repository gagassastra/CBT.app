<x-app-layout>
    <x-form-card
        title="Tambah Mata Pelajaran"
        subtitle="Tambahkan mata pelajaran baru ke dalam daftar kurikulum ujian."
        :back="route('admin.mapel.index')"
        :action="route('admin.mapel.store')"
        submit="Simpan Mata Pelajaran"
    >
        <x-field label="Nama Mata Pelajaran" name="nama_pelajaran" :full="true" :required="true" hint="Contoh: Matematika, Bahasa Indonesia, Bahasa Inggris, Pendidikan Kewarganegaraan.">
            <input type="text" id="nama_pelajaran" name="nama_pelajaran" value="{{ old('nama_pelajaran') }}" required autofocus placeholder="Masukkan nama mata pelajaran..." class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
