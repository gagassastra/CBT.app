<x-app-layout>
    <x-form-card
        title="Tambah Kelas Baru"
        subtitle="Masukkan nama tingkat atau rombongan belajar baru untuk PKBM AL-QUDWAH."
        :back="route('admin.kelas.index')"
        :action="route('admin.kelas.store')"
        submit="Simpan Kelas"
    >
        <x-field label="Nama Kelas" name="nama_kelas" :full="true" :required="true" hint="Contoh: Paket C Kelas XII, Paket B Kelas IX, atau Kelas X IPA.">
            <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" required autofocus placeholder="Masukkan nama kelas..." class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
