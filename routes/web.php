<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::resource('kelas', \App\Http\Controllers\KelasController::class);
    Route::resource('mapel', \App\Http\Controllers\MataPelajaranController::class);
    Route::resource('tahun_ajaran', \App\Http\Controllers\TahunAjaranController::class);
    Route::resource('pengguna', \App\Http\Controllers\UserController::class);
    Route::get('/siswa/export', [\App\Http\Controllers\SiswaDataController::class, 'exportCsv'])->name('siswa.export');
    Route::post('/siswa/import', [\App\Http\Controllers\SiswaDataController::class, 'importCsv'])->name('siswa.import');
    Route::get('/siswa/semua-kartu', [\App\Http\Controllers\SiswaDataController::class, 'cetakSemuaKartu'])->name('siswa.kartu_semua');
    Route::get('/siswa/{id}/kartu', [\App\Http\Controllers\SiswaDataController::class, 'cetakKartu'])->name('siswa.kartu');
    Route::resource('siswa', \App\Http\Controllers\SiswaDataController::class);
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', function () { return view('guru.dashboard'); })->name('dashboard');
    Route::resource('ujian', \App\Http\Controllers\UjianController::class);
    Route::resource('ujian.soal', \App\Http\Controllers\SoalController::class);
    Route::get('/laporan', [\App\Http\Controllers\Guru\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [\App\Http\Controllers\Guru\LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{id}/pdf', [\App\Http\Controllers\Guru\LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
});

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () { return view('siswa.dashboard'); })->name('dashboard');
    Route::get('/ujian', [\App\Http\Controllers\UjianController::class, 'indexSiswa'])->name('ujian.index');
    Route::post('/ujian/{ujian}/mulai', [\App\Http\Controllers\UjianController::class, 'mulai'])->name('ujian.mulai');
    Route::get('/ujian/{ujian}/kerjakan', [\App\Http\Controllers\UjianController::class, 'kerjakan'])->name('ujian.kerjakan');
    Route::post('/ujian/{ujian}/simpan', [\App\Http\Controllers\UjianController::class, 'simpanJawaban'])->name('ujian.simpan');
    Route::post('/ujian/{ujian}/selesai', [\App\Http\Controllers\UjianController::class, 'selesai'])->name('ujian.selesai');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return redirect()->route($role . '.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
