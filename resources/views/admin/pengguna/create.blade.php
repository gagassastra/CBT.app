<x-app-layout>
    <x-form-card
        title="Tambah Pengguna Baru"
        subtitle="Daftarkan akun Administrator atau Guru pengajar baru beserta foto profil ke dalam sistem."
        :back="route('admin.pengguna.index')"
        :action="route('admin.pengguna.store')"
        submit="Simpan Pengguna"
        :files="true"
    >
        <x-field label="Foto Profil (Opsional)" name="foto" :full="true" hint="Format: JPG, PNG, atau WebP (Maksimal 2 MB).">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100">
                <div class="relative w-16 h-16 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 text-white font-extrabold text-xl flex items-center justify-center shadow-sm border border-indigo-200 shrink-0">
                    <img id="foto-preview" src="" alt="Preview Foto" class="w-full h-full object-cover hidden">
                    <svg id="foto-placeholder" class="w-8 h-8 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex-1">
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        accept="image/jpeg,image/png,image/webp"
                        onchange="previewFotoBaru(this)"
                        class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer"
                    >
                </div>
            </div>
        </x-field>

        <x-field label="Nama Lengkap" name="name" :full="true" :required="true">
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap beserta gelar..." class="ui-input">
        </x-field>

        <x-field label="Alamat Email" name="email" :required="true" hint="Digunakan sebagai username saat login.">
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@alqudwah.sch.id" class="ui-input">
        </x-field>

        <x-field label="Peran / Hak Akses" name="role" :required="true">
            <select id="role" name="role" class="ui-select">
                <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru Pengajar</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
        </x-field>

        <x-field label="Kata Sandi" name="password" :full="true" :required="true" hint="Minimal 6 karakter.">
            <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi..." class="ui-input">
        </x-field>
    </x-form-card>

    <script>
        function previewFotoBaru(input) {
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
