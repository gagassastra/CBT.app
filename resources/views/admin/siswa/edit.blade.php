<x-app-layout>
<x-slot name="header"><h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Panel Utama</h2></x-slot>
<div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white mt-8 p-8 rounded-[2rem] shadow-xl shadow-slate-200/40 border border-slate-100'>
<form action='{{ route('admin.siswa.update', $data->id) }}' method='POST'>
@csrf @method('PUT')
<div class='mb-4'><label>Nama</label><input type='text' name='name' value='{{ $data->name }}' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class='mb-4'><label>NISN</label><input type='text' name='nisn' value='{{ $data->nisn }}' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class='mb-4'><label>Tempat Lahir</label><input type='text' name='tempat_lahir' value='{{ $data->tempat_lahir }}' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class='mb-4'><label>Tanggal Lahir</label><input type='date' name='tanggal_lahir' value='{{ $data->tanggal_lahir }}' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></div>
<div class='mb-4'>
    <label>Kelas</label>
    <select name='kelas_id' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelas as $k)
            <option value="{{ $k->id }}" {{ $data->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
        @endforeach
    </select>
</div>
<button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm transition-all">Update</button>
</form></div>
</x-app-layout>
