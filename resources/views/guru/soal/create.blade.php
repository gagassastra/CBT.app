<x-app-layout>
<x-slot name="header">
    <div class="flex items-center">
        <a href="{{ route(auth()->user()->role . '.ujian.show', $ujian_id) }}" class="mr-4 text-slate-500 hover:text-blue-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Buat Soal</h2>
    </div>
</x-slot>

<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <p class="text-xs mt-2 text-red-600">Catatan: file media perlu dipilih ulang bila halaman gagal disimpan.</p>
        </div>
    @endif

    <form id="soal-form" action="{{ route(auth()->user()->role . '.ujian.soal.store', $ujian_id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Header seperti Google Forms -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 border-t-8 border-t-blue-600 p-6 mb-4">
            <h3 class="text-2xl font-bold text-slate-800">Daftar Soal</h3>
            <p class="text-sm text-slate-500 mt-1">Tambahkan sebanyak mungkin soal dalam satu halaman, lalu simpan sekaligus. Pilih kunci jawaban dengan menandai tombol bulat di samping opsi.</p>
            <p class="text-sm text-slate-600 mt-3 font-semibold">Total: <span id="total-soal">0</span> soal</p>
        </div>

        <div id="soal-list" class="space-y-4"></div>

        <div class="mt-4 flex flex-col sm:flex-row sm:justify-between gap-3 sticky bottom-0 bg-slate-50/90 backdrop-blur py-4 border-t border-slate-200 -mx-4 px-4">
            <button type="button" id="btn-add" class="inline-flex items-center justify-center bg-white hover:bg-blue-50 border border-blue-300 text-blue-700 font-semibold py-3 px-6 rounded-xl shadow-sm transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Soal
            </button>
            <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Semua Soal
            </button>
        </div>
    </form>
</div>

<!-- Template satu kartu soal. __K__ = kunci unik -->
<template id="soal-template">
    <div class="soal-card bg-white rounded-xl shadow-sm border border-slate-200 border-l-8 border-l-transparent focus-within:border-l-blue-500 p-6 transition" data-key="__K__">
        <div class="flex items-center justify-between mb-4">
            <span class="soal-number bg-blue-100 text-blue-800 text-xs font-extrabold px-3 py-1 rounded-full">Soal #</span>
            <div class="flex items-center gap-1">
                <button type="button" data-action="up" title="Naikkan" class="p-2 rounded-full text-slate-500 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                </button>
                <button type="button" data-action="down" title="Turunkan" class="p-2 rounded-full text-slate-500 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <button type="button" data-action="duplicate" title="Duplikat soal" class="p-2 rounded-full text-slate-500 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
                </button>
                <button type="button" data-action="delete" title="Hapus soal" class="p-2 rounded-full text-red-500 hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>

        <textarea name="soal[__K__][pertanyaan]" data-field="pertanyaan" rows="2" required placeholder="Tulis pertanyaan..."
            class="block w-full bg-slate-50 border-0 border-b-2 border-slate-300 focus:border-blue-600 focus:ring-0 rounded-t-lg text-base p-3"></textarea>

        <!-- Media -->
        <div class="mt-3">
            <label class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium cursor-pointer">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Tambah gambar/video <span class="text-xs text-slate-400 ml-1">(maks. 5 file, 20MB/file)</span>
                <input type="file" name="soal[__K__][media_files][]" data-field="media" accept="image/*,video/*" multiple class="sr-only">
            </label>
            <div class="media-preview grid grid-cols-2 sm:grid-cols-3 gap-3 mt-3"></div>
        </div>

        <!-- Opsi -->
        <div class="mt-5 space-y-3">
            @foreach(['A','B','C','D'] as $o)
            <div class="flex items-center gap-3">
                <input type="radio" name="soal[__K__][jawaban_benar]" value="{{ $o }}" data-field="kunci" required title="Tandai sebagai jawaban benar" class="w-5 h-5 text-green-600 focus:ring-green-500 border-slate-400 cursor-pointer shrink-0">
                <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-sm font-bold flex items-center justify-center shrink-0">{{ $o }}</span>
                <input type="text" name="soal[__K__][opsi_{{ strtolower($o) }}]" data-field="opsi_{{ strtolower($o) }}" required placeholder="Opsi {{ $o }}"
                    class="block w-full border-0 border-b border-slate-300 focus:border-blue-600 focus:ring-0 text-sm px-1 py-2">
            </div>
            @endforeach

            <div class="opsi-e-row hidden items-center gap-3">
                <input type="radio" name="soal[__K__][jawaban_benar]" value="E" data-field="kunci" title="Tandai sebagai jawaban benar" class="w-5 h-5 text-green-600 focus:ring-green-500 border-slate-400 cursor-pointer shrink-0">
                <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-sm font-bold flex items-center justify-center shrink-0">E</span>
                <input type="text" name="soal[__K__][opsi_e]" data-field="opsi_e" placeholder="Opsi E"
                    class="block w-full border-0 border-b border-slate-300 focus:border-blue-600 focus:ring-0 text-sm px-1 py-2">
                <button type="button" data-action="remove-e" title="Hapus opsi E" class="p-1 text-slate-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <button type="button" data-action="add-e" class="text-sm text-blue-600 hover:text-blue-800 font-medium ml-1">+ Tambah opsi E</button>
        </div>
        <p class="text-xs text-slate-400 mt-4">Bulatan = kunci jawaban benar.</p>
    </div>
</template>

<script>
(function () {
    const list = document.getElementById('soal-list');
    const tpl = document.getElementById('soal-template').innerHTML;
    const MAX_MEDIA = 5;
    let counter = 0;
    const filesByKey = {}; // key -> File[]

    function q(card, sel) { return card.querySelector(sel); }

    function addCard(data = {}, afterCard = null) {
        const key = counter++;
        const wrap = document.createElement('div');
        wrap.innerHTML = tpl.replaceAll('__K__', key).trim();
        const card = wrap.firstElementChild;
        filesByKey[key] = [];

        q(card, '[data-field="pertanyaan"]').value = data.pertanyaan || '';
        ['a','b','c','d','e'].forEach(l => { q(card, `[data-field="opsi_${l}"]`).value = data['opsi_' + l] || ''; });
        if (data.opsi_e) showE(card, true);
        if (data.jawaban_benar) {
            const r = card.querySelector(`[data-field="kunci"][value="${data.jawaban_benar}"]`);
            if (r) r.checked = true;
        }

        if (afterCard) afterCard.after(card); else list.appendChild(card);
        renumber();
        return card;
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
        cards.forEach((c, i) => { q(c, '.soal-number').textContent = 'Soal #' + (i + 1); });
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
            el.className = 'relative rounded-lg overflow-hidden border border-slate-200 bg-white p-1';
            el.innerHTML = (file.type.startsWith('video/')
                ? `<video class="w-full h-24 object-cover rounded" controls src="${url}"></video>`
                : `<img class="w-full h-24 object-cover rounded" src="${url}">`) +
                `<button type="button" data-rm="${idx}" style="background-color:#ef4444;color:white" class="absolute top-2 right-2 rounded-full p-1 shadow" title="Hapus">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button>`;
            box.appendChild(el);
        });
        input.files = dt.files;
    }

    list.addEventListener('change', function (e) {
        if (e.target.dataset.field !== 'media') return;
        const card = e.target.closest('.soal-card');
        const key = card.dataset.key;
        // Saat memilih file, browser mengganti input.files dengan file yang baru dipilih saja
        const merged = filesByKey[key].concat(Array.from(e.target.files));
        if (merged.length > MAX_MEDIA) {
            alert('Maksimal ' + MAX_MEDIA + ' file media per soal.');
            renderPreview(card); // kembalikan input ke state sebelumnya
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

    // Muat ulang isian bila validasi server gagal; jika tidak ada, mulai dengan satu soal kosong
    const old = @json(old('soal', []));
    const olds = Object.values(old || {});
    if (olds.length) olds.forEach(d => addCard(d)); else addCard();
})();
</script>
</x-app-layout>
