<x-app-layout>
<x-slot name="header"><h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">Panel Utama</h2></x-slot>
<div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white mt-8 p-8 rounded-[2rem] shadow-xl shadow-slate-200/40 border border-slate-100'>
<form action='{{ route('admin.kelas.store') }}' method='POST'>
@csrf
<div class='mb-4'><label>Nama Kelas</label><input type='text' name='nama_kelas' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-b border-slate-100/80lue-500 focus:ring-blue-500 sm:text-sm"></div>
<button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow-sm transition-all">Simpan</button>
</form></div>
</x-app-layout>
