<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaUjian extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'waktu_mulai_mengerjakan' => 'datetime',
        'waktu_selesai_mengerjakan' => 'datetime',
    ];
    public function ujian() {
        return $this->belongsTo(Ujian::class);
    }
    public function siswa() {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    public function jawabanSiswas() {
        return $this->hasMany(JawabanSiswa::class);
    }
    public function hasilUjian() {
        return $this->hasOne(HasilUjian::class);
    }

}
