<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div>
            <a href="{{ route(auth()->user()->role . '.ujian.show', $ujian_id) }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Soal Ujian
            </a>
        </div>

        @if($errors->any())
            <div class="p-4 bg-red-50 text-red-700 border border-red-200 rounded-2xl">
                <p class="font-bold text-sm mb-1">Periksa kembali isian soal Anda:</p>
                <ul class="list-disc pl-5 text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <p class="text-xs mt-2 text-red-600 font-medium">Catatan: File media perlu dipilih ulang bila halaman gagal disimpan.</p>
            </div>
        @endif

        <form id="soal-form" action="{{ route(auth()->user()->role . '.ujian.soal.store', $ujian_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Builder Header Card -->
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-8 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-blue-600 mb-1">Editor Bank Soal</div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Butir Soal Sekaligus</h1>
                    <p class="text-sm text-slate-500 mt-1">Tambahkan satu atau beberapa soal dalam satu halaman, lalu simpan sekaligus. Tandai tombol bulat di samping opsi sebagai kunci jawaban benar.</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold">
                        Soal Baru: <span id="total-soal">0</span>
                    </span>
                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">
                        Tersimpan: {{ $jumlahSoal }}
                    </span>
                </div>
            </div>

            <div id="soal-list" class="space-y-5"></div>

            <!-- Sticky Action Bar -->
            <div class="mt-6 flex flex-col sm:flex-row sm:justify-between gap-3 sticky bottom-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200/90 shadow-lg z-30">
                <button type="button" id="btn-add" class="ui-btn-secondary">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Kartu Soal
                </button>
                <button type="submit" class="ui-btn-primary px-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Semua Soal
                </button>
            </div>
        </form>
    </div>

    <!-- Template satu kartu soal. __K__ = kunci unik -->
    <template id="soal-template">
        <div class="soal-card bg-white rounded-2xl shadow-xs border border-slate-200/80 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/10 p-6 sm:p-7 transition" data-key="__K__">
            <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                <span class="soal-number bg-blue-600 text-white text-xs font-extrabold px-3.5 py-1.5 rounded-lg">Soal #</span>
                <div class="flex items-center gap-1">
                    <button type="button" data-action="up" title="Naikkan urutan" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                    </button>
                    <button type="button" data-action="down" title="Turunkan urutan" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <button type="button" data-action="duplicate" title="Duplikat soal" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                    </button>
                    <button type="button" data-action="delete" title="Hapus soal" class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div class="sm:col-span-2">
                    <label class="ui-label">Jenis Soal</label>
                    <select name="soal[__K__][tipe]" data-field="tipe" class="ui-select">
                        <option value="pilihan_ganda">Pilihan Ganda</option>
                        <option value="esai">Esai (Uraian)</option>
                    </select>
                </div>
                <div>
                    <label class="ui-label">Bobot Poin</label>
                    <input type="number" name="soal[__K__][bobot]" data-field="bobot" min="1" max="100" value="1" required class="ui-input">
                </div>
            </div>

            <div>
                <label class="ui-label">Teks Pertanyaan <span class="text-red-500">*</span></label>
                <textarea name="soal[__K__][pertanyaan]" data-field="pertanyaan" rows="3" required placeholder="Tuliskan butir pertanyaan dengan jelas..." class="ui-textarea"></textarea>
            </div>

            <!-- Media -->
            <div class="mt-4">
                <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-blue-50 text-xs font-bold text-blue-600 border border-slate-200 hover:border-blue-200 cursor-pointer transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Lampirkan Gambar / Video
                    <span class="text-[11px] font-medium text-slate-400">(Maks. 5 file, 20MB/file)</span>
                    <input type="file" name="soal[__K__][media_files][]" data-field="media" accept="image/*,video/*" multiple class="sr-only">
                </label>
                <div class="media-preview grid grid-cols-2 sm:grid-cols-3 gap-3 mt-3"></div>
            </div>

            <!-- Esai (Uraian) -->
            <div class="esai-section hidden mt-5 space-y-3 pt-4 border-t border-slate-100">
                <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-xs text-slate-500">
                    Siswa akan menjawab dengan teks uraian. Jawaban dikoreksi dan diberi skor oleh guru pada menu Laporan.
                </div>
                <div>
                    <label class="ui-label">Pedoman / Kunci Jawaban Esai <span class="text-xs font-normal text-slate-400">(Opsional, tampil saat guru mengoreksi)</span></label>
                    <textarea name="soal[__K__][pedoman]" data-field="pedoman" rows="2" disabled placeholder="Tuliskan poin-poin kunci jawaban..." class="ui-textarea"></textarea>
                </div>
            </div>

            <!-- Opsi Pilihan Ganda -->
            <div class="pg-section mt-5 space-y-3 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Opsi Jawaban & Kunci</span>
                    <span class="text-xs text-slate-400">Klik bulatan radio untuk memilih kunci jawaban benar</span>
                </div>
                @foreach(['A','B','C','D'] as $o)
                <div class="flex items-center gap-3">
                    <input type="radio" name="soal[__K__][jawaban_benar]" value="{{ $o }}" data-field="kunci" required title="Tandai sebagai jawaban benar" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 cursor-pointer shrink-0">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 text-xs font-extrabold flex items-center justify-center shrink-0">{{ $o }}</span>
                    <input type="text" name="soal[__K__][opsi_{{ strtolower($o) }}]" data-field="opsi_{{ strtolower($o) }}" required placeholder="Ketik teks opsi {{ $o }}..." class="ui-input">
                </div>
                @endforeach

                <div class="opsi-e-row hidden items-center gap-3">
                    <input type="radio" name="soal[__K__][jawaban_benar]" value="E" data-field="kunci" title="Tandai sebagai jawaban benar" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 cursor-pointer shrink-0">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 text-xs font-extrabold flex items-center justify-center shrink-0">E</span>
                    <input type="text" name="soal[__K__][opsi_e]" data-field="opsi_e" placeholder="Ketik teks opsi E..." class="ui-input">
                    <button type="button" data-action="remove-e" title="Hapus opsi E" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <button type="button" data-action="add-e" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-700 mt-1">
                    + Tambah Opsi E
                </button>
            </div>
            <p class="pg-hint text-xs text-slate-400 mt-3">Pastikan satu bulatan kunci jawaban telah dipilih pada setiap soal pilihan ganda.</p>
        </div>
    </template>

    <script>
    (function () {
        const list = document.getElementById('soal-list');
        const tpl = document.getElementById('soal-template').innerHTML;
        const MAX_MEDIA = 5;
        const START = @json((int) $jumlahSoal);
        let counter = 0;
        const filesByKey = {};

        function q(card, sel) { return card.querySelector(sel); }

        function addCard(data = {}, afterCard = null) {
            const key = counter++;
            const wrap = document.createElement('div');
            wrap.innerHTML = tpl.replaceAll('__K__', key).trim();
            const card = wrap.firstElementChild;
            filesByKey[key] = [];

            q(card, '[data-field="pertanyaan"]').value = data.pertanyaan || '';
            q(card, '[data-field="bobot"]').value = data.bobot || 1;
            q(card, '[data-field="pedoman"]').value = data.pedoman || '';
            ['a','b','c','d','e'].forEach(l => { q(card, `[data-field="opsi_${l}"]`).value = data['opsi_' + l] || ''; });
            if (data.opsi_e) showE(card, true);
            q(card, '[data-field="tipe"]').value = data.tipe === 'esai' ? 'esai' : 'pilihan_ganda';
            setTipe(card);
            if (data.jawaban_benar) {
                const r = card.querySelector(`[data-field="kunci"][value="${data.jawaban_benar}"]`);
                if (r) r.checked = true;
            }

            if (afterCard) afterCard.after(card); else list.appendChild(card);
            renumber();
            return card;
        }

        function setTipe(card) {
            const esai = q(card, '[data-field="tipe"]').value === 'esai';
            const pg = q(card, '.pg-section');
            const es = q(card, '.esai-section');
            pg.classList.toggle('hidden', esai);
            es.classList.toggle('hidden', !esai);
            q(card, '.pg-hint').classList.toggle('hidden', esai);
            pg.querySelectorAll('input, textarea, select').forEach(el => { el.disabled = esai; });
            es.querySelectorAll('input, textarea, select').forEach(el => { el.disabled = !esai; });
        }

        function showE(card, show) {
            const row = q(card, '.opsi-e-row');
            row.classList.toggle('hidden', !show);
            row.classList.toggle('flex', show);
            q(card, '[data-action="add-e"]').classList.toggle('hidden', show);
            if (!show) {
                q(card, '[data-field="opsi_e"]').value = '';
                q(card, '[data-field="kunci"][value="E"]').checked = false;
            }
        }

        function renumber() {
            const cards = list.querySelectorAll('.soal-card');
            cards.forEach((c, i) => { q(c, '.soal-number').textContent = 'Soal #' + (START + i + 1); });
            document.getElementById('total-soal').textContent = cards.length;
        }

        function renderPreview(card) {
            const key = card.dataset.key;
            const box = q(card, '.media-preview');
            const input = q(card, '[data-field="media"]');
            box.innerHTML = '';
            const dt = new DataTransfer();
            filesByKey[key].forEach((file, idx) => {
                dt.items.add(file);
                const url = URL.createObjectURL(file);
                const el = document.createElement('div');
                el.className = 'relative rounded-xl overflow-hidden border border-slate-200 bg-white p-1.5 shadow-2xs';
                el.innerHTML = (file.type.startsWith('video/')
                    ? `<video class="w-full h-24 object-cover rounded-lg" controls src="${url}"></video>`
                    : `<img class="w-full h-24 object-cover rounded-lg" src="${url}">`) +
                    `<button type="button" data-rm="${idx}" class="absolute top-2.5 right-2.5 bg-red-600 text-white rounded-full p-1 shadow" title="Hapus">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>`;
                box.appendChild(el);
            });
            input.files = dt.files;
        }

        list.addEventListener('change', function (e) {
            if (e.target.dataset.field === 'tipe') { setTipe(e.target.closest('.soal-card')); return; }
            if (e.target.dataset.field !== 'media') return;
            const card = e.target.closest('.soal-card');
            const key = card.dataset.key;
            const merged = filesByKey[key].concat(Array.from(e.target.files));
            if (merged.length > MAX_MEDIA) {
                alert('Maksimal ' + MAX_MEDIA + ' file media per soal.');
                renderPreview(card);
                return;
            }
            filesByKey[key] = merged;
            renderPreview(card);
        });

        list.addEventListener('click', function (e) {
            const rm = e.target.closest('[data-rm]');
            const act = e.target.closest('[data-action]');
            const card = e.target.closest('.soal-card');
            if (!card) return;

            if (rm) {
                filesByKey[card.dataset.key].splice(parseInt(rm.dataset.rm), 1);
                renderPreview(card);
                return;
            }
            if (!act) return;

            switch (act.dataset.action) {
                case 'delete':
                    if (list.querySelectorAll('.soal-card').length === 1) { alert('Minimal harus ada satu soal.'); return; }
                    if (!confirm('Hapus soal ini?')) return;
                    delete filesByKey[card.dataset.key];
                    card.remove();
                    renumber();
                    break;
                case 'duplicate': {
                    const kunci = card.querySelector('[data-field="kunci"]:checked');
                    const copy = addCard({
                        tipe: q(card, '[data-field="tipe"]').value,
                        bobot: q(card, '[data-field="bobot"]').value,
                        pedoman: q(card, '[data-field="pedoman"]').value,
                        pertanyaan: q(card, '[data-field="pertanyaan"]').value,
                        opsi_a: q(card, '[data-field="opsi_a"]').value,
                        opsi_b: q(card, '[data-field="opsi_b"]').value,
                        opsi_c: q(card, '[data-field="opsi_c"]').value,
                        opsi_d: q(card, '[data-field="opsi_d"]').value,
                        opsi_e: q(card, '[data-field="opsi_e"]').value,
                        jawaban_benar: kunci ? kunci.value : null,
                    }, card);
                    copy.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    break;
                }
                case 'up':
                    if (card.previousElementSibling) { card.previousElementSibling.before(card); renumber(); }
                    break;
                case 'down':
                    if (card.nextElementSibling) { card.nextElementSibling.after(card); renumber(); }
                    break;
                case 'add-e': showE(card, true); break;
                case 'remove-e': showE(card, false); break;
            }
        });

        document.getElementById('btn-add').addEventListener('click', function () {
            const card = addCard();
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            q(card, '[data-field="pertanyaan"]').focus({ preventScroll: true });
        });

        const old = @json(old('soal', []));
        const olds = Object.values(old || {});
        if (olds.length) olds.forEach(d => addCard(d)); else addCard();
    })();
    </script>
</x-app-layout>
