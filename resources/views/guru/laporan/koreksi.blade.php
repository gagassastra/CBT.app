<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Koreksi Soal Esai</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <a href="{{ route(auth()->user()->role . '.laporan.show', $ujian->id) }}" class="text-slate-500 hover:text-blue-600 text-sm font-semibold mb-3 inline-block">&larr; Kembali ke Detail Nilai</a>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $ujian->nama_ujian }}</h1>
            <p class="text-slate-500 mt-1 text-sm">Siswa: <span class="font-semibold text-slate-700">{{ $peserta->siswa->name ?? 'Siswa' }}</span>
                @if($peserta->hasilUjian)
                    &nbsp;|&nbsp; Nilai saat ini: <span class="font-bold text-blue-600">{{ number_format($peserta->hasilUjian->nilai_akhir, 0) }}</span>
                @endif
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route(auth()->user()->role . '.laporan.koreksi.simpan', $peserta->id) }}" method="POST" class="space-y-4">
            @csrf
            @forelse($soals as $no => $soal)
                @php $jawab = $jawabans->get($soal->id); @endphp
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-purple-100 text-purple-800 text-xs font-extrabold px-3 py-1 rounded-full">Esai {{ $no + 1 }}</span>
                        <span class="text-xs text-slate-500">Poin maksimal: <b>{{ $soal->bobot ?? 1 }}</b></span>
                    </div>
                    <p class="text-slate-800 font-medium whitespace-pre-line">{{ $soal->pertanyaan }}</p>

                    @if($soal->pedoman)
                        <div class="mt-3 text-sm bg-amber-50 border border-amber-200 text-amber-800 rounded-lg p-3">
                            <b>Pedoman:</b> <span class="whitespace-pre-line">{{ $soal->pedoman }}</span>
                        </div>
                    @endif

                    <div class="mt-4">
                        <p class="text-xs font-semibold text-slate-500 mb-1">Jawaban siswa</p>
                        @if($jawab && trim((string) $jawab->jawaban) !== '')
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-slate-800 whitespace-pre-line break-words">{{ $jawab->jawaban }}</div>
                            <div class="mt-4 flex items-center gap-3">
                                <label class="text-sm font-semibold text-slate-700">Skor</label>
                                <input type="number" name="skor[{{ $jawab->id }}]" min="0" max="{{ $soal->bobot ?? 1 }}" step="0.5"
                                    value="{{ old('skor.' . $jawab->id, $jawab->skor) }}" placeholder="0 - {{ $soal->bobot ?? 1 }}"
                                    class="w-28 rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <span class="text-xs text-slate-400">Kosongkan bila belum dinilai</span>
                            </div>
                        @else
                            <div class="text-sm italic text-slate-400">Tidak dijawab (skor 0)</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-dashed border-slate-300 p-10 text-center text-slate-500">Ujian ini tidak memiliki soal esai.</div>
            @endforelse

            @if($soals->count())
                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition">Simpan Koreksi</button>
                </div>
            @endif
        </form>
    </div>
</x-app-layout>
