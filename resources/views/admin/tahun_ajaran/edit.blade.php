<x-app-layout>
    <x-form-card
        title="Perbarui Tahun Ajaran"
        subtitle="Ubah informasi periode tahun ajaran atau status keaktifannya."
        :back="route('admin.tahun_ajaran.index')"
        :action="route('admin.tahun_ajaran.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan"
    >
        <x-field label="Tahun Ajaran" name="tahun_ajaran" :required="true">
            <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $data->tahun_ajaran) }}" required autofocus class="ui-input">
        </x-field>

        <x-field label="Status Periode" name="status" :required="true">
            <select id="status" name="status" class="ui-select">
                <option value="aktif" {{ old('status', $data->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $data->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </x-field>
    </x-form-card>
</x-app-layout>
