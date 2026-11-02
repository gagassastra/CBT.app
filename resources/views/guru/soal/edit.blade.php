<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div>
            <a href="{{ route(auth()->user()->role . '.ujian.show', $ujian_id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white/80 border border-indigo-200/80 text-sm font-bold text-indigo-700 hover:bg-indigo-50 transition shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Soal Ujian
            </a>
        </div>

        <div class="bg-gradient-to-b from-white via-white to-indigo-50/40 rounded-2xl shadow-md shadow-indigo-950/5 border border-indigo-100 overflow-hidden">
            <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 px-6 sm:px-8 py-6 text-white flex items-center justify-between">
                <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-cyan-400/15 blur-2xl pointer-events-none"></div>
                <div class="relative z-10">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-white/15 text-cyan-200 border border-white/15 mb-2">
                        Editor Bank Soal
                    </span>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Perbarui Butir Soal</h1>
                    <p class="text-sm text-blue-100/85 mt-1">Ubah teks pertanyaan, lampiran media, opsi pilihan ganda, atau kunci jawaban.</p>
                </div>
                <div class="relative z-10 hidden sm:flex w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md text-cyan-300 border border-white/20 items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
            </div>

            <form action="{{ route(auth()->user()->role . '.ujian.soal.update', [$ujian_id, $data->id]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl">
                        <ul class="list-disc pl-5 text-xs space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($data->media_files && count($data->media_files) > 0)
                    <div id="old-media-container" class="p-5 bg-slate-50 border border-slate-200/80 rounded-xl">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Media Terlampir Saat Ini</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($data->media_files as $index => $media)
                                <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-white p-2" id="old-media-{{ $index }}">
                                    @if(preg_match('/^.*\.(mp4|webm)$/i', $media))
                                        <video controls class="w-full h-32 object-cover rounded-lg"><source src="{{ asset('storage/' . $media) }}"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $media) }}" class="w-full h-32 object-cover rounded-lg">
                                    @endif
                                    <label class="mt-2 flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-xs px-2.5 py-1.5 rounded-lg cursor-pointer border border-red-200 font-bold transition">
                                        <input type="checkbox" name="delete_media[]" value="{{ $media }}" class="rounded border-red-300 text-red-600 focus:ring-red-500">
                                        Hapus Media
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <label class="ui-label">Tambah Media Pendukung <span class="text-xs font-normal text-slate-400 ml-1">(Maks. 5 total file, 20MB/file)</span></label>
                    <div class="mt-1 flex justify-center px-6 py-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-blue-400 hover:bg-blue-50/40 transition">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer rounded-md font-bold text-blue-600 hover:text-blue-700">
                                    <span>Pilih file gambar atau video tambahan</span>
                                    <input id="file-upload" name="media_files[]" type="file" accept="image/*,video/*" multiple class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-slate-400">Format: PNG, JPG, MP4, WebM</p>
                        </div>
                    </div>
                    <div id="media-preview-container" class="hidden mt-4 bg-slate-50 p-4 border border-slate-200 rounded-xl">
                        <div id="preview-list" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="ui-label">Jenis Soal</label>
                        <select name="tipe" id="tipe-soal" class="ui-select">
                            <option value="pilihan_ganda" {{ old('tipe', $data->tipe) !== 'esai' ? 'selected' : '' }}>Pilihan Ganda</option>
                            <option value="esai" {{ old('tipe', $data->tipe) === 'esai' ? 'selected' : '' }}>Esai (Uraian)</option>
                        </select>
                    </div>
                    <div>
                        <label class="ui-label">Bobot Poin</label>
                        <input type="number" name="bobot" min="1" max="100" required value="{{ old('bobot', $data->bobot ?? 1) }}" class="ui-input">
                    </div>
                </div>

                <div>
                    <label class="ui-label">Teks Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea name="pertanyaan" rows="4" required class="ui-textarea">{{ old('pertanyaan', $data->pertanyaan) }}</textarea>
                </div>

                <div id="pg-section" class="space-y-6">
                    <div class="bg-slate-50/80 p-5 sm:p-6 rounded-2xl border border-slate-200/80 space-y-4">
                        <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider border-b border-slate-200 pb-2.5">Opsi Pilihan Ganda</h4>

                        @foreach(['A' => 'opsi_a', 'B' => 'opsi_b', 'C' => 'opsi_c', 'D' => 'opsi_d'] as $letter => $field)
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 font-extrabold text-xs flex items-center justify-center shrink-0">{{ $letter }}</span>
                                <input type="text" name="{{ $field }}" value="{{ old($field, $data->$field) }}" required class="ui-input bg-white">
                            </div>
                        @endforeach

                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-slate-200 text-slate-700 font-extrabold text-xs flex items-center justify-center shrink-0">E</span>
                            <input type="text" name="opsi_e" value="{{ old('opsi_e', $data->opsi_e) }}" placeholder="Opsi E (Opsional)" class="ui-input bg-white">
                        </div>
                    </div>

                    <div class="max-w-xs">
                        <label class="ui-label">Kunci Jawaban Benar <span class="text-red-500">*</span></label>
                        <select name="jawaban_benar" required class="ui-select">
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $opt)
                                <option value="{{ $opt }}" {{ old('jawaban_benar', $data->jawaban_benar) == $opt ? 'selected' : '' }}>Opsi {{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="esai-section" class="hidden space-y-4">
                    <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3.5 text-xs text-slate-500">
                        Siswa menjawab dengan teks uraian. Jawaban dikoreksi dan diberi skor oleh guru pada menu Laporan.
                    </div>
                    <div>
                        <label class="ui-label">Pedoman / Kunci Jawaban Esai <span class="text-xs font-normal text-slate-400">(Opsional)</span></label>
                        <textarea name="pedoman" rows="3" class="ui-textarea">{{ old('pedoman', $data->pedoman) }}</textarea>
                    </div>
                </div>

                <div class="pt-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <a href="{{ route(auth()->user()->role . '.ujian.show', $ujian_id) }}" class="ui-btn-ghost">Batal</a>
                    <button type="submit" class="ui-btn-primary px-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleTipe() {
            const esai = document.getElementById('tipe-soal').value === 'esai';
            const pg = document.getElementById('pg-section');
            const es = document.getElementById('esai-section');
            pg.classList.toggle('hidden', esai);
            es.classList.toggle('hidden', !esai);
            pg.querySelectorAll('input, textarea, select').forEach(el => el.disabled = esai);
            es.querySelectorAll('input, textarea, select').forEach(el => el.disabled = !esai);
        }
        document.getElementById('tipe-soal').addEventListener('change', toggleTipe);
        toggleTipe();

        let selectedFiles = [];
        document.getElementById('file-upload').addEventListener('change', function(event) {
            const files = Array.from(event.target.files);
            const currentExisting = document.querySelectorAll('input[name="delete_media[]"]:not(:checked)').length;
            const total = currentExisting + selectedFiles.length + files.length;
            if (total > 5) {
                alert('Maksimal hanya 5 file media yang diperbolehkan per soal secara total.');
                return;
            }
            files.forEach(file => selectedFiles.push(file));
            renderPreviews();
            updateFileInput();
        });

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            renderPreviews();
            updateFileInput();
        }

        function renderPreviews() {
            const container = document.getElementById('media-preview-container');
            const list = document.getElementById('preview-list');
            list.innerHTML = '';
            if (selectedFiles.length === 0) {
                container.classList.add('hidden');
                return;
            }
            container.classList.remove('hidden');
            selectedFiles.forEach((file, index) => {
                const fileURL = URL.createObjectURL(file);
                const isVideo = file.type.startsWith('video/');
                const div = document.createElement('div');
                div.className = 'relative group rounded-xl overflow-hidden border border-slate-200 bg-white p-2';
                let mediaHtml = isVideo
                    ? `<video class="w-full h-32 object-cover rounded-lg" controls><source src="${fileURL}"></video>`
                    : `<img class="w-full h-32 object-cover rounded-lg" src="${fileURL}">`;
                div.innerHTML = `
                    ${mediaHtml}
                    <button type="button" onclick="removeFile(${index})" class="absolute top-3 right-3 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-md transition z-10" title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="mt-2 text-xs text-center text-slate-600 truncate font-medium bg-slate-100 p-1 rounded">${file.name}</div>
                `;
                list.appendChild(div);
            });
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            document.getElementById('file-upload').files = dt.files;
        }
    </script>
</x-app-layout>
