<x-app-layout>
    <x-form-card
        title="Tambah Tahun Ajaran"
        subtitle="Tetapkan periode tahun ajaran baru beserta status keaktifannya."
        :back="route('admin.tahun_ajaran.index')"
        :action="route('admin.tahun_ajaran.store')"
        submit="Simpan Tahun Ajaran"
    >
        <x-field label="Tahun Ajaran" name="tahun_ajaran" :required="true" hint="Contoh: 2026/2027 Ganjil atau 2026/2027.">
            <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" required autofocus placeholder="Contoh: 2026/2027" class="ui-input">
        </x-field>

        <x-field label="Status Periode" name="status" :required="true">
            <select id="status" name="status" class="ui-select">
                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </x-field>
    </x-form-card>
</x-app-layout>
