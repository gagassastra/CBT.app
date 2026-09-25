<x-app-layout>
<x-slot name="header"><h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Panel Utama</h2></x-slot>
<div class='max-w-7xl mx-auto py-6 bg-white p-6 rounded shadow'>
<form action='{{ route('guru.ujian.update', $data->id) }}' method='POST'>
@csrf @method('PUT')
@if($errors->any())
<div class='mb-4 p-4 bg-red-100 text-red-700 rounded-lg'>
    <ul class='list-disc pl-5'>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class='mb-4'><label>Nama Ujian</label><input type='text' name='nama_ujian' value='{{ $data->nama_ujian }}' required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class='mb-4'><label>Mata Pelajaran</label><select name='mata_pelajaran_id' required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm">@foreach($mapels as $m)<option value='{{$m->id}}' {{$data->mata_pelajaran_id == $m->id ? 'selected' : ''}}>{{$m->nama_pelajaran}}</option>@endforeach</select></div>
<div class='mb-4'><label>Kelas</label><select name='kelas_id' required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm">@foreach($kelas as $k)<option value='{{$k->id}}' {{$data->kelas_id == $k->id ? 'selected' : ''}}>{{$k->nama_kelas}}</option>@endforeach</select></div>
<div class='mb-4'><label>Tahun Ajaran</label><select name='tahun_ajaran_id' required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm">@foreach($tahun as $t)<option value='{{$t->id}}' {{$data->tahun_ajaran_id == $t->id ? 'selected' : ''}}>{{$t->tahun_ajaran}}</option>@endforeach</select></div>
<div class='mb-4'><label>Durasi (Menit)</label><input type='number' name='durasi' value='{{ $data->durasi }}' required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class='mb-4'><label>Waktu Mulai</label><input type='datetime-local' name='waktu_mulai' value='{{ date('Y-m-d\TH:i', strtotime($data->waktu_mulai)) }}' required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class="mt-8 flex justify-end">
    <button class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">Simpan Perubahan Ujian</button>
</div>
</form></div>
</x-app-layout>