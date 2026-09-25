<x-app-layout>
<x-slot name="header">
    <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Kelola Soal Ujian</h2>
</x-slot>

<div class='max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8'>
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8 flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-blue-50 to-white">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $ujian->nama_ujian }}</h1>
            <p class="text-slate-500 mt-2 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Durasi: {{ $ujian->durasi }} Menit &nbsp; | &nbsp; 
                <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Total Soal: {{ count($ujian->soals) }}
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href='{{ route('guru.ujian.soal.create', $ujian->id) }}' class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Soal Baru
            </a>
        </div>
    </div>

    <!-- Questions List -->
    <div class="space-y-4">
        @forelse($ujian->soals as $index => $soal)
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition duration-200">
            <div class="flex justify-between items-start">
                <div class="flex-1 pr-4">
                    <div class="flex items-center mb-3">
                        <span class="bg-blue-100 text-blue-800 text-xs font-extrabold px-3 py-1 rounded-full mr-3">Soal #{{ $index + 1 }}</span>
                        @if($soal->media_files && count($soal->media_files) > 0) 
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded-full flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ count($soal->media_files) }} Media
                            </span> 
                        @endif
                    </div>
                    <p class="text-slate-800 font-medium text-lg leading-relaxed">{{ Str::limit($soal->pertanyaan, 150) }}</p>
                </div>
                
                <div class="flex flex-col space-y-2 shrink-0">
                    <a href='{{ route('guru.ujian.soal.edit', [$ujian->id, $soal->id]) }}' class="inline-flex items-center justify-center bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg text-sm transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a> 
                    <form action='{{ route('guru.ujian.soal.destroy', [$ujian->id, $soal->id]) }}' method='POST' class='inline'>
                        @csrf @method('DELETE')
                        <button style="background-color: #ef4444; color: white;" class="inline-flex items-center justify-center w-full hover:bg-red-600 shadow-sm font-bold px-4 py-2 rounded-lg text-sm transition transform hover:-translate-y-0.5" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini secara permanen?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada soal</h3>
            <p class="mt-1 text-sm text-slate-500">Mulai buat bank soal Anda dengan menambahkan soal pertama.</p>
            <div class="mt-6">
                <a href='{{ route('guru.ujian.soal.create', $ujian->id) }}' class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Buat Soal Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
</x-app-layout>