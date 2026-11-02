<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div>
            <a href="{{ route(auth()->user()->role . '.laporan.show', $ujian->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white/80 border border-indigo-200/80 text-sm font-bold text-indigo-700 hover:bg-indigo-50 transition shadow-2xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Detail Nilai Ujian
            </a>
        </div>

        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 rounded-2xl shadow-lg shadow-indigo-950/10 border border-indigo-500/20 p-6 sm:p-8 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-violet-500/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-bold uppercase tracking-wider text-cyan-300 mb-2">Penilaian Jawaban Uraian</span>
                <h1 class="text-2xl font-extrabold text-white mt-0.5">{{ $ujian->nama_ujian }}</h1>
                <p class="text-blue-100/85 mt-1 text-sm">
                    Peserta: <strong class="text-white">{{ $peserta->siswa->name ?? 'Siswa' }}</strong>
                </p>
            </div>
            @if($peserta->hasilUjian)
                <div class="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-6 py-3.5 text-center shrink-0">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-cyan-200">Nilai Akhir Saat Ini</span>
                    <span class="text-2xl font-extrabold text-white">{{ number_format($peserta->hasilUjian->nilai_akhir, 0) }}</span>
                </div>
            @endif
        </div>

        @if($errors->any())
            <div class="p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl">
                <ul class="list-disc pl-5 text-xs space-y-0.5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route(auth()->user()->role . '.laporan.koreksi.simpan', $peserta->id) }}" method="POST" class="space-y-4">
            @csrf
            @forelse($soals as $no => $soal)
                @php $jawab = $jawabans->get($soal->id); @endphp
                <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="bg-purple-50 text-purple-700 border border-purple-200 text-xs font-extrabold px-3 py-1 rounded-lg">
                            Soal Esai #{{ $no + 1 }}
                        </span>
                        <span class="text-xs font-semibold text-slate-500">
                            Bobot Maksimal: <strong class="text-slate-800">{{ $soal->bobot ?? 1 }} Poin</strong>
                        </span>
                    </div>

                    <p class="text-slate-800 font-semibold text-base whitespace-pre-line">{{ $soal->pertanyaan }}</p>

                    @if($soal->pedoman)
                        <div class="text-xs bg-amber-50/80 border border-amber-200 text-amber-900 rounded-xl p-3.5">
                            <strong class="block mb-0.5">Pedoman / Kunci Jawaban:</strong>
                            <span class="whitespace-pre-line">{{ $soal->pedoman }}</span>
                        </div>
                    @endif

                    <div class="pt-1">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Jawaban Siswa</p>
                        @if($jawab && trim((string) $jawab->jawaban) !== '')
                            <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 text-sm text-slate-800 whitespace-pre-line break-words leading-relaxed">{{ $jawab->jawaban }}</div>
                            <div class="mt-4 flex flex-wrap items-center gap-3 bg-blue-50/50 p-3.5 rounded-xl border border-blue-100">
                                <label class="text-sm font-bold text-slate-700">Berikan Skor:</label>
                                <input type="number" name="skor[{{ $jawab->id }}]" min="0" max="{{ $soal->bobot ?? 1 }}" step="0.5"
                                    value="{{ old('skor.' . $jawab->id, $jawab->skor) }}" placeholder="0 - {{ $soal->bobot ?? 1 }}"
                                    class="ui-input w-32 bg-white">
                                <span class="text-xs text-slate-500">dari maksimal <strong>{{ $soal->bobot ?? 1 }}</strong> poin</span>
                            </div>
                        @else
                            <div class="text-sm italic text-slate-400 bg-slate-50 border border-dashed border-slate-200 rounded-xl p-4">
                                Siswa tidak mengisi jawaban pada soal ini (Skor otomatis 0).
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center text-slate-500">
                    Ujian ini tidak memiliki butir soal esai.
                </div>
            @endforelse

            @if($soals->count())
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route(auth()->user()->role . '.laporan.show', $ujian->id) }}" class="ui-btn-ghost">Batal</a>
                    <button type="submit" class="ui-btn-primary px-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Hasil Koreksi
                    </button>
                </div>
            @endif
        </form>
    </div>
</x-app-layout>
