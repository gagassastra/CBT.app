<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    //

    public const TIPE_PG = 'pilihan_ganda';
    public const TIPE_ESAI = 'esai';

    protected $guarded = [];
    protected $casts = [
        'media_files' => 'array',
    ];
    public function ujian() {
        return $this->belongsTo(Ujian::class);
    }
    public function jawabanSiswas() {
        return $this->hasMany(JawabanSiswa::class);
    }
    public function isEsai(): bool {
        return $this->tipe === self::TIPE_ESAI;
    }

}
