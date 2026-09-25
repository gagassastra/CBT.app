<x-app-layout>
<x-slot name="header">
    <div class="flex items-center">
        <a href="{{ route('guru.ujian.show', $ujian_id) }}" class="mr-4 text-slate-500 hover:text-blue-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Buat Soal Baru</h2>
    </div>
</x-slot>

<div class='max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8'>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center">
            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Detail Soal & Jawaban</h3>
                <p class="text-sm text-slate-500">Lengkapi pertanyaan dan opsi jawaban di bawah ini.</p>
            </div>
        </div>

        <div class="p-8">
            @if($errors->any())
                <div class='mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl'>
                    <ul class='list-disc pl-5 text-sm'>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action='{{ route('guru.ujian.soal.store', $ujian_id) }}' method='POST' enctype='multipart/form-data'>
                @csrf
                
                <div class='mb-6'>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Media Pendukung (Foto/Video) <span class="text-xs font-normal text-slate-500 ml-1">*Opsional, Maks. 5 file, per file max 20MB</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:border-blue-400 hover:bg-blue-50/50 transition duration-150">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span class="px-2">Pilih file untuk diunggah</span>
                                    <input id="file-upload" name="media_files[]" type="file" accept="image/*,video/*" multiple class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, MP4 hingga 20MB</p>
                        </div>
                    </div>
                    <!-- Preview Container -->
                    <div id="media-preview-container" class="hidden mt-4 bg-slate-50 p-4 border border-slate-200 rounded-xl">
                        <div id="preview-list" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                    </div>
                </div>

                <div class='mb-8'>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Teks Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea name='pertanyaan' rows="4" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-4"></textarea>
                </div>

                <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 mb-8 space-y-5">
                    <h4 class="font-semibold text-slate-700 text-sm mb-4 border-b border-slate-200 pb-2">Pilihan Ganda</h4>
                    
                    <div class='flex items-center gap-4'>
                        <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">A</span>
                        <input type='text' name='opsi_a' required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    
                    <div class='flex items-center gap-4'>
                        <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">B</span>
                        <input type='text' name='opsi_b' required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    
                    <div class='flex items-center gap-4'>
                        <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">C</span>
                        <input type='text' name='opsi_c' required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    
                    <div class='flex items-center gap-4'>
                        <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">D</span>
                        <input type='text' name='opsi_d' required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    
                    <div class='flex items-center gap-4'>
                        <span class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center shrink-0">E</span>
                        <div class="w-full relative">
                            <input type='text' name='opsi_e' placeholder="(Opsional)" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white">
                        </div>
                    </div>
                </div>

                <div class='mb-8'>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kunci Jawaban <span class="text-red-500">*</span></label>
                    <select name='jawaban_benar' required class="block w-full md:w-1/3 rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3 font-semibold text-slate-700">
                        <option value='' disabled selected>Pilih Jawaban Benar...</option>
                        <option value='A'>Jawaban A</option>
                        <option value='B'>Jawaban B</option>
                        <option value='C'>Jawaban C</option>
                        <option value='D'>Jawaban D</option>
                        <option value='E'>Jawaban E</option>
                    </select>
                </div>
                
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Soal ke Bank Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let selectedFiles = [];
    
    document.getElementById('file-upload').addEventListener('change', function(event) {
        const files = Array.from(event.target.files);
        if (selectedFiles.length + files.length > 5) {
            alert('Maksimal hanya 5 file media yang diperbolehkan per soal.');
            return;
        }
        
        files.forEach(file => {
            selectedFiles.push(file);
        });
        
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
            div.className = 'relative group rounded-lg overflow-hidden border border-slate-200 shadow-sm bg-white p-2';
            
            let mediaHtml = isVideo 
                ? `<video class="w-full h-32 object-cover rounded" controls><source src="${fileURL}"></video>`
                : `<img class="w-full h-32 object-cover rounded" src="${fileURL}">`;
                
            div.innerHTML = `
                ${mediaHtml}
                <button type="button" onclick="removeFile(${index})" style="background-color: #ef4444; color: white;" class="absolute top-2 right-2 hover:bg-red-600 rounded-full p-1.5 shadow-md transition-all z-10" title="Hapus Gambar Ini">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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