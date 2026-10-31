<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'skor' => 'float',
    ];
    public function pesertaUjian() {
        return $this->belongsTo(PesertaUjian::class);
    }
    public function soal() {
        return $this->belongsTo(Soal::class);
    }

}
