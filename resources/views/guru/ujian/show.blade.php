<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Back Navigation -->
        <div>
            <a href="{{ route(auth()->user()->role . '.ujian.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Ujian
            </a>
        </div>

        <!-- Exam Summary Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold">
                        {{ $ujian->mataPelajaran->nama_pelajaran ?? 'Mata Pelajaran' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-bold">
                        Kelas: {{ $ujian->kelas->nama_kelas ?? '-' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold">
                        Durasi: {{ $ujian->durasi }} Menit
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $ujian->nama_ujian }}</h1>
                <p class="text-slate-500 mt-1 text-sm">
                    Total Terdaftar: <strong class="text-slate-800">{{ count($ujian->soals) }} Butir Soal</strong>
                </p>
            </div>
            <div class="flex flex-wrap gap-3 w-full md:w-auto">
                <a href="{{ route(auth()->user()->role . '.ujian.soal.create', $ujian->id) }}" class="ui-btn-primary w-full md:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Soal Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl flex items-center gap-3 shadow-2xs text-sm font-semibold">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Questions List -->
        <div class="space-y-4">
            @forelse($ujian->soals as $index => $soal)
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 hover:border-blue-200 transition">
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1 space-y-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-blue-600 text-white text-xs font-extrabold px-3 py-1 rounded-lg">
                                    Soal #{{ $index + 1 }}
                                </span>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-lg border {{ $soal->isEsai() ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                    {{ $soal->isEsai() ? 'Esai (Uraian)' : 'Pilihan Ganda' }} &bull; {{ $soal->bobot ?? 1 }} Poin
                                </span>
                                @if(!$soal->isEsai() && $soal->jawaban_benar)
                                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-2.5 py-1 rounded-lg">
                                        Kunci: {{ $soal->jawaban_benar }}
                                    </span>
                                @endif
                                @if($soal->media_files && count($soal->media_files) > 0)
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold px-2.5 py-1 rounded-lg inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ count($soal->media_files) }} Media
                                    </span>
                                @endif
                            </div>

                            <p class="text-slate-800 font-semibold text-base leading-relaxed whitespace-pre-line">{{ $soal->pertanyaan }}</p>

                            @if(!$soal->isEsai())
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2">
                                    @foreach(['A' => 'opsi_a', 'B' => 'opsi_b', 'C' => 'opsi_c', 'D' => 'opsi_d', 'E' => 'opsi_e'] as $letter => $field)
                                        @if($soal->$field)
                                            <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl border text-xs {{ $soal->jawaban_benar === $letter ? 'bg-emerald-50/70 border-emerald-200 text-emerald-900 font-bold' : 'bg-slate-50/70 border-slate-200/70 text-slate-600' }}">
                                                <span class="w-5 h-5 rounded-md flex items-center justify-center text-[11px] font-extrabold shrink-0 {{ $soal->jawaban_benar === $letter ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                                                    {{ $letter }}
                                                </span>
                                                <span class="truncate">{{ $soal->$field }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($soal->pedoman)
                                <div class="text-xs bg-amber-50/80 border border-amber-200 text-amber-800 rounded-xl px-3.5 py-2.5">
                                    <strong>Pedoman Koreksi:</strong> {{ $soal->pedoman }}
                                </div>
                            @endif
                        </div>

                        <div class="flex sm:flex-col gap-2 shrink-0 w-full sm:w-auto justify-end">
                            <a href="{{ route(auth()->user()->role . '.ujian.soal.edit', [$ujian->id, $soal->id]) }}" class="inline-flex items-center justify-center gap-1.5 bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-bold px-3.5 py-2 rounded-xl text-xs transition flex-1 sm:flex-initial">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route(auth()->user()->role . '.ujian.soal.destroy', [$ujian->id, $soal->id]) }}" method="POST" class="flex-1 sm:flex-initial" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center gap-1.5 w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3.5 py-2 rounded-xl text-xs transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300 px-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Belum Ada Butir Soal</h3>
                    <p class="mt-1 text-sm text-slate-500 max-w-md mx-auto">Mulai susun bank soal pilihan ganda atau esai untuk jadwal ujian ini.</p>
                    <div class="mt-5">
                        <a href="{{ route(auth()->user()->role . '.ujian.soal.create', $ujian->id) }}" class="ui-btn-primary">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                            Buat Soal Pertama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
