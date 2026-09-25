<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    //

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

}
