<x-app-layout>
    <x-form-card
        title="Perbarui Data Siswa"
        subtitle="Ubah identitas, NISN, atau penempatan kelas siswa."
        :back="route('admin.siswa.index')"
        :action="route('admin.siswa.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan"
    >
        <x-field label="Nama Lengkap Siswa" name="name" :full="true" :required="true">
            <input type="text" id="name" name="name" value="{{ old('name', $data->name) }}" required autofocus class="ui-input">
        </x-field>

        <x-field label="NISN (Username Login)" name="nisn" :required="true">
            <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $data->nisn) }}" required class="ui-input">
        </x-field>

        <x-field label="Kelas Rombongan Belajar" name="kelas_id" :required="true">
            <select id="kelas_id" name="kelas_id" required class="ui-select">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </x-field>

        <x-field label="Tempat Lahir" name="tempat_lahir">
            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $data->tempat_lahir) }}" class="ui-input">
        </x-field>

        <x-field label="Tanggal Lahir" name="tanggal_lahir">
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}" class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
