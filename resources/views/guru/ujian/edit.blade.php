<x-app-layout>
    <x-form-card
        title="Perbarui Jadwal Ujian"
        subtitle="Ubah informasi nama ujian, kelas, waktu pelaksanaan, atau durasi pengerjaan."
        :back="route(auth()->user()->role . '.ujian.index')"
        :action="route(auth()->user()->role . '.ujian.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan Ujian"
    >
        <x-field label="Nama / Judul Ujian" name="nama_ujian" :full="true" :required="true">
            <input type="text" id="nama_ujian" name="nama_ujian" value="{{ old('nama_ujian', $data->nama_ujian) }}" required autofocus class="ui-input">
        </x-field>

        <x-field label="Mata Pelajaran" name="mata_pelajaran_id" :required="true">
            <select id="mata_pelajaran_id" name="mata_pelajaran_id" required class="ui-select">
                @foreach($mapels as $m)
                    <option value="{{ $m->id }}" {{ old('mata_pelajaran_id', $data->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>{{ $m->nama_pelajaran }}</option>
                @endforeach
            </select>
        </x-field>

        <x-field label="Kelas Target" name="kelas_id" :required="true">
            <select id="kelas_id" name="kelas_id" required class="ui-select">
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </x-field>

        <x-field label="Tahun Ajaran" name="tahun_ajaran_id" :required="true">
            <select id="tahun_ajaran_id" name="tahun_ajaran_id" required class="ui-select">
                @foreach($tahun as $t)
                    <option value="{{ $t->id }}" {{ old('tahun_ajaran_id', $data->tahun_ajaran_id) == $t->id ? 'selected' : '' }}>{{ $t->tahun_ajaran }}</option>
                @endforeach
            </select>
        </x-field>

        <x-field label="Durasi Pengerjaan (Menit)" name="durasi" :required="true">
            <input type="number" id="durasi" name="durasi" min="1" value="{{ old('durasi', $data->durasi) }}" required class="ui-input">
        </x-field>

        <x-field label="Waktu Mulai Ujian" name="waktu_mulai" :full="true" :required="true">
            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', date('Y-m-d\TH:i', strtotime($data->waktu_mulai))) }}" required class="ui-input">
        </x-field>
    </x-form-card>
</x-app-layout>
