<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Daftar Ujian Siswa
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Ujian Tersedia</h1>
            <p class="text-blue-100 mt-1 text-sm">Pilih ujian yang sedang berlangsung dan pastikan Anda mengerjakan dengan jujur.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($data as $row)
                @php
                    $peserta = \App\Models\PesertaUjian::where('ujian_id', $row->id)->where('siswa_id', auth()->id())->first();
                    $hasil = $peserta ? \App\Models\HasilUjian::where('peserta_ujian_id', $peserta->id)->first() : null;
                    
                    $isSelesai = $peserta && $peserta->status == 'selesai';
                    $isMengerjakan = $peserta && $peserta->status == 'mengerjakan';
                    $statusAktif = $row->status_aktif;
                @endphp
                <div class="bg-white rounded-[2rem] shadow-lg shadow-slate-200/40 border border-slate-100 flex flex-col overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                    
                    <!-- Card Top -->
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $statusAktif == 'Aktif' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                {{ $row->mataPelajaran->nama_pelajaran ?? 'Mapel' }} | {{ $statusAktif }}
                            </span>
                            
                            @if($isSelesai)
                                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Selesai
                                </span>
                            @elseif($isMengerjakan)
                                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full flex items-center animate-pulse">
                                    Sedang Dikerjakan
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $row->nama_ujian }}</h3>
                        <p class="text-sm text-slate-500 mb-6">Oleh: {{ $row->guru->name ?? 'Guru' }}</p>

                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <span class="block text-xs text-slate-400 font-medium">Durasi Ujian</span>
                                <span class="block text-sm font-bold text-slate-700">{{ $row->durasi }} Menit</span>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <span class="block text-xs text-slate-400 font-medium">Jumlah Soal</span>
                                <span class="block text-sm font-bold text-slate-700">{{ $row->soals ? $row->soals->count() : 0 }} Soal</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Bottom / Actions -->
                    <div class="bg-slate-50 p-6 border-t border-slate-100">
                        @if($isSelesai)
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium text-slate-500">Nilai Akhir Anda:</div>
                                    <div class="text-3xl font-black text-blue-600 drop-shadow-sm">{{ $hasil ? number_format($hasil->nilai_akhir, 0) : 'N/A' }}</div>
                                </div>
                                @if($hasil)
                                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 mt-2 border-t border-slate-100 pt-2">
                                    <span class="text-emerald-500">Benar: {{ $hasil->jumlah_benar }}</span>
                                    <span class="text-red-500">Salah: {{ $hasil->jumlah_salah }}</span>
                                    <span class="text-slate-400">Kosong: {{ $hasil->tidak_dijawab }}</span>
                                </div>
                                @endif
                            </div>
                        @else
                            @if($statusAktif == 'Aktif')
                                <form action="{{ route('siswa.ujian.mulai', $row->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-blue-500/30 transition-all">
                                        {{ $isMengerjakan ? 'Lanjutkan Pengerjaan' : 'Mulai Kerjakan Sekarang' }}
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </form>
                            @else
                                <div class="w-full text-center py-3 px-4 rounded-xl bg-gray-100 text-gray-500 font-bold border border-gray-200">
                                    {{ $statusAktif == 'Belum Mulai' ? 'Ujian Belum Dimulai' : 'Ujian Telah Selesai' }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center shadow-sm border border-slate-100">
                    <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="text-lg font-bold text-slate-800">Tidak ada ujian</h3>
                    <p class="text-slate-500 mt-2">Belum ada ujian yang tersedia untuk Anda saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>


