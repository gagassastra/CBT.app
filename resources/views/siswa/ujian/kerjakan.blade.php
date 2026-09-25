<x-app-layout>
<x-slot name="header"><h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Panel Utama</h2></x-slot>
<div class='max-w-7xl mx-auto py-6 flex flex-col md:flex-row gap-4 px-4 sm:px-6 lg:px-8'>
<div class='w-full md:w-3/4 bg-white p-6 shadow rounded-xl' id='soal-container'>
<h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $ujian->nama_ujian }}</h2><hr class='my-4'>
@foreach($ujian->soals as $i => $soal)
<div class='soal-item' id='soal-{{$i}}' style='display: {{ $i==0 ? 'block' : 'none' }}'>
@if($soal->media_files && count($soal->media_files) > 0)
<div class='mb-6 flex flex-wrap justify-center gap-4'>
    @foreach($soal->media_files as $media)
        @if(preg_match('/^.*\.(mp4|webm)$/i', $media))
            <video controls class="max-w-full md:max-w-md w-full rounded shadow-sm border border-gray-200"><source src="{{ asset('storage/' . $media) }}"></video>
        @else
            <img src="{{ asset('storage/' . $media) }}" class="max-w-full md:max-w-md w-full rounded shadow-sm border border-gray-200 object-contain">
        @endif
    @endforeach
</div>
@endif
<p class="text-lg text-gray-800 mb-4"><b>{{ $i+1 }}.</b> {{ $soal->pertanyaan }}</p>
@foreach(['a','b','c','d','e'] as $opt)
@if($soal->{'opsi_'.$opt})
<div><label><input type='radio' name='jawaban_{{$soal->id}}' value='{{ strtoupper($opt) }}' onchange="simpanJawaban('{{$soal->id}}', this.value)"> {{ $soal->{'opsi_'.$opt} }}</label></div>
@endif
@endforeach
</div>
@endforeach
<div class='mt-4 flex justify-between'>
<button onclick='prevSoal()' class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded shadow-sm transition-all">Sebelumnya</button>
<button id='btnNext' onclick='nextSoal()' class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm transition-all">Selanjutnya</button>
</div>
</div>
<div class='w-full md:w-1/4 bg-white p-4 shadow rounded-xl text-center flex flex-col sm:flex-row md:flex-col items-center justify-between md:justify-start gap-4 md:gap-0'>
<div>
<h3 class='text-lg font-bold text-slate-700'>Sisa Waktu</h3>
<h2 id='timer' class='text-3xl font-extrabold text-red-600 mt-2 md:mt-4'></h2>
</div>
<hr class='my-0 md:my-4 hidden md:block w-full'>
</div>
</div>
<form id='formSelesai' action='{{ route('siswa.ujian.selesai', $ujian->id) }}' method='POST' style='display:none;'>@csrf</form>
<script>
let current = 0; let total = {{ count($ujian->soals) }};
function showSoal(idx) {
 document.querySelectorAll('.soal-item').forEach(el => el.style.display='none');
 document.getElementById('soal-'+idx).style.display='block';
 current = idx;
 
 let btnNext = document.getElementById('btnNext');
 if(current === total - 1) {
     btnNext.innerHTML = 'Kumpulkan Ujian &nbsp; &check;';
     btnNext.className = 'bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3 px-8 rounded-lg shadow-lg transition-all border-2 border-emerald-500 animate-pulse';
 } else {
     btnNext.innerHTML = 'Selanjutnya &nbsp; &rarr;';
     btnNext.className = 'bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm transition-all';
 }
}

// Initial call to set button text if total is 1
if(total > 0) showSoal(0);

function nextSoal() { 
    if(current < total-1) {
        showSoal(current+1); 
    } else {
        if(confirm('Apakah Anda yakin sudah selesai dan ingin mengumpulkan ujian ini?')) {
            document.getElementById('formSelesai').submit();
        }
    }
}
function prevSoal() { if(current > 0) showSoal(current-1); }
function simpanJawaban(soal_id, jawaban) {
 fetch('{{ route('siswa.ujian.simpan', $ujian->id) }}', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
  body: JSON.stringify({ soal_id, jawaban })
 });
}
// Timer Logic
@php
   $endTime = \Carbon\Carbon::parse($peserta->waktu_mulai_mengerjakan)->addMinutes($ujian->durasi);
   $sisaDetik = (int) now()->diffInSeconds($endTime, false);
   if($sisaDetik < 0) $sisaDetik = 0;
@endphp
let duration = {{ $sisaDetik }};
let timerInterval = setInterval(function() {
 duration--;
 let m = Math.floor(duration / 60); 
 let s = Math.floor(duration % 60);
 document.getElementById('timer').innerText = m + 'm ' + s + 's';
 if(duration <= 0) { clearInterval(timerInterval); document.getElementById('formSelesai').submit(); }
}, 1000);
</script>
</x-app-layout>