<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Exam Top Sticky Status Bar -->
        <div class="bg-slate-900 text-white rounded-2xl p-4 sm:p-5 shadow-lg border border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-blue-600/20 border border-blue-500/30 text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-400">{{ $ujian->mataPelajaran->nama_pelajaran ?? 'Ujian CBT' }}</span>
                        <span class="text-slate-600">&bull;</span>
                        <span id="save-indicator" class="text-xs font-medium text-emerald-400">Autosave Aktif</span>
                    </div>
                    <h1 class="text-lg sm:text-xl font-extrabold tracking-tight text-white">{{ $ujian->nama_ujian }}</h1>
                </div>
            </div>

            <!-- Live Countdown Box -->
            <div class="flex items-center justify-between sm:justify-end gap-4 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-800">
                <div class="text-left sm:text-right">
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Sisa Waktu Pengerjaan</span>
                    <div id="timer" class="text-xl sm:text-2xl font-mono font-extrabold text-emerald-400 tracking-wider">--:--</div>
                </div>
                <button type="button" onclick="konfirmasiKumpulkan()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-sm transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Selesai Ujian
                </button>
            </div>
        </div>

        <!-- Main Exam Workspace Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left Column: Active Question Card -->
            <div class="lg:col-span-8 bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden" id="soal-container">
                @foreach($ujian->soals as $i => $soal)
                    @php
                        $savedVal = $jawabans[$soal->id] ?? '';
                    @endphp
                    <div class="soal-item p-6 sm:p-8" id="soal-{{ $i }}" data-index="{{ $i }}" data-soal-id="{{ $soal->id }}" style="display: {{ $i == 0 ? 'block' : 'none' }}">
                        <!-- Question Meta Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-5 mb-6 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="px-3.5 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-extrabold shadow-2xs">
                                    Soal No. {{ $i + 1 }}
                                </span>
                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">
                                    {{ $soal->isEsai() ? 'Uraian / Esai' : 'Pilihan Ganda' }}
                                </span>
                            </div>
                            <span class="text-xs font-bold text-slate-400">
                                Bobot: <strong class="text-slate-700">{{ $soal->bobot ?? 1 }} Poin</strong>
                            </span>
                        </div>

                        <!-- Attached Media -->
                        @if($soal->media_files && count($soal->media_files) > 0)
                            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                                @foreach($soal->media_files as $media)
                                    @if(preg_match('/^.*\.(mp4|webm)$/i', $media))
                                        <video controls class="w-full rounded-xl shadow-2xs border border-slate-200 bg-black max-h-72"><source src="{{ asset('storage/' . $media) }}"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $media) }}" alt="Media Soal" class="w-full rounded-xl shadow-2xs border border-slate-200 object-contain max-h-72 bg-white">
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Question Prompt -->
                        <div class="text-base sm:text-lg font-semibold text-slate-800 leading-relaxed whitespace-pre-line mb-6">{{ $soal->pertanyaan }}</div>

                        <!-- Answer Input Area -->
                        @if($soal->isEsai())
                            <div class="space-y-2">
                                <label for="esai_{{ $soal->id }}" class="text-xs font-bold uppercase tracking-wider text-slate-500">Jawaban Uraian Anda:</label>
                                <textarea
                                    id="esai_{{ $soal->id }}"
                                    data-soal-id="{{ $soal->id }}"
                                    data-question-index="{{ $i }}"
                                    rows="7"
                                    maxlength="20000"
                                    placeholder="Ketik jawaban uraian Anda secara lengkap di sini..."
                                    class="esai-input ui-textarea text-base"
                                >{{ $savedVal }}</textarea>
                                <p class="text-xs text-slate-400 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Jawaban esai tersimpan otomatis saat Anda mengetik dan akan dinilai oleh guru.
                                </p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach(['a','b','c','d','e'] as $opt)
                                    @if($soal->{'opsi_'.$opt})
                                        @php
                                            $upperOpt = strtoupper($opt);
                                            $isChecked = $savedVal === $upperOpt;
                                        @endphp
                                        <label
                                            class="option-card-{{ $i }} flex items-start gap-3.5 p-4 rounded-2xl border-2 cursor-pointer transition-all {{ $isChecked ? 'border-blue-600 bg-blue-50/60 shadow-2xs' : 'border-slate-200/80 bg-white hover:border-blue-300 hover:bg-slate-50/60' }}"
                                        >
                                            <input
                                                type="radio"
                                                name="jawaban_{{ $soal->id }}"
                                                value="{{ $upperOpt }}"
                                                data-question-index="{{ $i }}"
                                                {{ $isChecked ? 'checked' : '' }}
                                                onchange="pilihOpsi('{{ $soal->id }}', this.value, {{ $i }})"
                                                class="sr-only"
                                            >
                                            <span class="option-badge w-8 h-8 rounded-xl text-xs font-extrabold flex items-center justify-center shrink-0 transition {{ $isChecked ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                                                {{ $upperOpt }}
                                            </span>
                                            <span class="text-sm sm:text-base font-medium text-slate-800 leading-relaxed pt-0.5 flex-1">
                                                {{ $soal->{'opsi_'.$opt} }}
                                            </span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Question Prev / Next Footer -->
                <div class="px-6 sm:px-8 py-5 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-4">
                    <button type="button" id="btnPrev" onclick="prevSoal()" class="ui-btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Sebelumnya
                    </button>

                    <span class="text-xs font-bold text-slate-400 hidden sm:inline" id="progress-label">
                        Soal 1 dari {{ count($ujian->soals) }}
                    </span>

                    <button type="button" id="btnNext" onclick="nextSoal()" class="ui-btn-primary">
                        Selanjutnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Right Column: Question Number Navigation Grid -->
            <div class="lg:col-span-4 bg-white rounded-2xl shadow-md shadow-indigo-950/5 border border-indigo-100 overflow-hidden sticky top-24">
                <div class="px-6 py-4 bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-950 text-white flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-extrabold text-white uppercase tracking-wider">Navigasi Nomor Soal</h3>
                        <p class="text-xs text-blue-200/80 mt-0.5">Klik nomor untuk berpindah soal</p>
                    </div>
                    <span id="answered-count" class="px-3 py-1 rounded-full text-xs font-bold bg-cyan-400/20 text-cyan-200 border border-cyan-300/30">
                        0 / {{ count($ujian->soals) }}
                    </span>
                </div>

                <div class="p-6">
                <!-- Grid of Numbers -->
                <div class="grid grid-cols-5 gap-2.5 mb-6">
                    @foreach($ujian->soals as $i => $soal)
                        @php
                            $hasAns = isset($jawabans[$soal->id]) && trim((string) $jawabans[$soal->id]) !== '';
                        @endphp
                        <button
                            type="button"
                            id="nav-btn-{{ $i }}"
                            data-answered="{{ $hasAns ? '1' : '0' }}"
                            onclick="showSoal({{ $i }})"
                            class="h-10 rounded-xl text-xs font-extrabold transition flex items-center justify-center border"
                        >
                            {{ $i + 1 }}
                        </button>
                    @endforeach
                </div>

                <!-- Legend -->
                <div class="space-y-2 text-xs text-slate-600 pt-4 border-t border-indigo-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3.5 h-3.5 rounded bg-emerald-600 inline-block"></span>
                        <span>Sudah Dijawab</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-3.5 h-3.5 rounded border-2 border-blue-600 bg-blue-50 inline-block"></span>
                        <span>Sedang Dilihat</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-3.5 h-3.5 rounded border border-slate-300 bg-slate-50 inline-block"></span>
                        <span>Belum Dijawab</span>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-indigo-100">
                    <button type="button" onclick="konfirmasiKumpulkan()" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-5 py-3 text-sm font-bold text-white shadow-md shadow-emerald-600/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Kumpulkan Ujian Sekarang
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <form id="formSelesai" action="{{ route('siswa.ujian.selesai', $ujian->id) }}" method="POST" class="hidden">@csrf</form>

    <script>
        let current = 0;
        const total = {{ count($ujian->soals) }};

        function updateNavStyles() {
            let answeredTotal = 0;
            for (let i = 0; i < total; i++) {
                const btn = document.getElementById('nav-btn-' + i);
                if (!btn) continue;
                const isAnswered = btn.dataset.answered === '1';
                if (isAnswered) answeredTotal++;

                if (i === current) {
                    btn.className = 'h-10 rounded-xl text-xs font-extrabold transition flex items-center justify-center border-2 border-blue-600 bg-blue-50 text-blue-700 ring-2 ring-blue-500/20';
                } else if (isAnswered) {
                    btn.className = 'h-10 rounded-xl text-xs font-extrabold transition flex items-center justify-center border border-emerald-600 bg-emerald-600 text-white shadow-2xs';
                } else {
                    btn.className = 'h-10 rounded-xl text-xs font-extrabold transition flex items-center justify-center border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100';
                }
            }
            const countEl = document.getElementById('answered-count');
            if (countEl) countEl.textContent = answeredTotal + ' / ' + total + ' Terjawab';
        }

        function showSoal(idx) {
            document.querySelectorAll('.soal-item').forEach(el => el.style.display = 'none');
            const target = document.getElementById('soal-' + idx);
            if (target) target.style.display = 'block';
            current = idx;

            const prevBtn = document.getElementById('btnPrev');
            if (prevBtn) {
                prevBtn.disabled = (current === 0);
                prevBtn.classList.toggle('opacity-40', current === 0);
                prevBtn.classList.toggle('pointer-events-none', current === 0);
            }

            const progressLabel = document.getElementById('progress-label');
            if (progressLabel) {
                progressLabel.textContent = 'Soal ' + (current + 1) + ' dari ' + total;
            }

            const btnNext = document.getElementById('btnNext');
            if (btnNext) {
                if (current === total - 1) {
                    btnNext.innerHTML = 'Kumpulkan Ujian &check;';
                    btnNext.className = 'inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-600/20 transition';
                } else {
                    btnNext.innerHTML = 'Selanjutnya &rarr;';
                    btnNext.className = 'ui-btn-primary';
                }
            }

            updateNavStyles();
        }

        function pilihOpsi(soalId, value, questionIndex) {
            // Update option card styling
            const cards = document.querySelectorAll('.option-card-' + questionIndex);
            cards.forEach(card => {
                const input = card.querySelector('input[type="radio"]');
                const badge = card.querySelector('.option-badge');
                if (input && input.value === value) {
                    card.className = 'option-card-' + questionIndex + ' flex items-start gap-3.5 p-4 rounded-2xl border-2 cursor-pointer transition-all border-blue-600 bg-blue-50/60 shadow-2xs';
                    if (badge) badge.className = 'option-badge w-8 h-8 rounded-xl text-xs font-extrabold flex items-center justify-center shrink-0 transition bg-blue-600 text-white';
                } else {
                    card.className = 'option-card-' + questionIndex + ' flex items-start gap-3.5 p-4 rounded-2xl border-2 cursor-pointer transition-all border-slate-200/80 bg-white hover:border-blue-300 hover:bg-slate-50/60';
                    if (badge) badge.className = 'option-badge w-8 h-8 rounded-xl text-xs font-extrabold flex items-center justify-center shrink-0 transition bg-slate-100 text-slate-700';
                }
            });

            const navBtn = document.getElementById('nav-btn-' + questionIndex);
            if (navBtn) navBtn.dataset.answered = '1';
            updateNavStyles();

            simpanJawaban(soalId, value);
        }

        function nextSoal() {
            if (current < total - 1) {
                showSoal(current + 1);
            } else {
                konfirmasiKumpulkan();
            }
        }

        function prevSoal() {
            if (current > 0) showSoal(current - 1);
        }

        function konfirmasiKumpulkan() {
            if (confirm('Apakah Anda yakin sudah selesai dan ingin mengumpulkan jawaban ujian ini?')) {
                kumpulkan();
            }
        }

        function simpanJawaban(soal_id, jawaban) {
            const indicator = document.getElementById('save-indicator');
            if (indicator) indicator.textContent = 'Menyimpan...';

            return fetch('{{ route('siswa.ujian.simpan', $ujian->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ soal_id, jawaban })
            }).then(() => {
                if (indicator) indicator.textContent = 'Tersimpan otomatis';
            }).catch(() => {
                if (indicator) indicator.textContent = 'Gangguan koneksi';
            });
        }

        let esaiTimers = {};
        document.querySelectorAll('.esai-input').forEach(el => {
            el.addEventListener('input', () => {
                const qIdx = el.dataset.questionIndex;
                const navBtn = document.getElementById('nav-btn-' + qIdx);
                if (navBtn) {
                    navBtn.dataset.answered = el.value.trim() !== '' ? '1' : '0';
                    updateNavStyles();
                }
                clearTimeout(esaiTimers[el.dataset.soalId]);
                esaiTimers[el.dataset.soalId] = setTimeout(() => simpanJawaban(el.dataset.soalId, el.value), 700);
            });
        });

        let sedangKumpul = false;
        async function kumpulkan() {
            if (sedangKumpul) return;
            sedangKumpul = true;
            const saves = Array.from(document.querySelectorAll('.esai-input')).map(el => {
                clearTimeout(esaiTimers[el.dataset.soalId]);
                return simpanJawaban(el.dataset.soalId, el.value);
            });
            await Promise.all(saves);
            document.getElementById('formSelesai').submit();
        }

        if (total > 0) showSoal(0);

        @php
            $endTime = \Carbon\Carbon::parse($peserta->waktu_mulai_mengerjakan)->addMinutes($ujian->durasi);
            $sisaDetik = (int) now()->diffInSeconds($endTime, false);
            if($sisaDetik < 0) $sisaDetik = 0;
        @endphp
        let duration = {{ $sisaDetik }};
        const timerEl = document.getElementById('timer');

        function renderTimer() {
            const hrs = Math.floor(duration / 3600);
            const mins = Math.floor((duration % 3600) / 60);
            const secs = Math.floor(duration % 60);
            const pad = n => String(n).padStart(2, '0');
            timerEl.innerText = hrs > 0
                ? `${pad(hrs)}:${pad(mins)}:${pad(secs)}`
                : `${pad(mins)}:${pad(secs)}`;

            if (duration <= 300) {
                timerEl.className = 'text-xl sm:text-2xl font-mono font-extrabold text-red-400 tracking-wider animate-pulse';
            }
        }
        renderTimer();

        let timerInterval = setInterval(function() {
            duration--;
            if (duration < 0) duration = 0;
            renderTimer();
            if (duration <= 0) {
                clearInterval(timerInterval);
                kumpulkan();
            }
        }, 1000);
    </script>
</x-app-layout>
