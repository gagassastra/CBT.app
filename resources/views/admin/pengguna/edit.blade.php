<x-app-layout>
    <x-form-card
        title="Perbarui Data Pengguna"
        subtitle="Ubah informasi profil, foto, alamat email, kata sandi, atau hak akses pengguna."
        :back="route('admin.pengguna.index')"
        :action="route('admin.pengguna.update', $data->id)"
        method="PUT"
        submit="Simpan Perubahan"
        :files="true"
    >
        <x-field label="Foto Profil" name="foto" :full="true" hint="Format: JPG, PNG, atau WebP (Maksimal 2 MB).">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100">
                <div class="relative w-16 h-16 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-extrabold text-xl flex items-center justify-center shadow-sm border border-indigo-200 shrink-0">
                    @if($data->foto_url)
                        <img id="foto-preview" src="{{ $data->foto_url }}" alt="{{ $data->name }}" class="w-full h-full object-cover">
                        <span id="foto-placeholder" class="hidden">{{ strtoupper(substr($data->name, 0, 1)) }}</span>
                    @else
                        <img id="foto-preview" src="" alt="{{ $data->name }}" class="w-full h-full object-cover hidden">
                        <span id="foto-placeholder">{{ strtoupper(substr($data->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="flex-1 space-y-2">
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        accept="image/jpeg,image/png,image/webp"
                        onchange="previewFotoEdit(this)"
                        class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer"
                    >
                    @if($data->foto_url)
                        <label class="inline-flex items-center gap-2 text-xs font-semibold text-rose-600 cursor-pointer">
                            <input type="checkbox" name="hapus_foto" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                            Hapus foto profil saat ini
                        </label>
                    @endif
                </div>
            </div>
        </x-field>

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

    <script>
        function previewFotoEdit(input) {
            const preview = document.getElementById('foto-preview');
            const placeholder = document.getElementById('foto-placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
