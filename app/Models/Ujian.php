<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    //

    protected $guarded = [];
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];
    public function mataPelajaran() {
        return $this->belongsTo(MataPelajaran::class);
    }
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }
    public function tahunAjaran() {
        return $this->belongsTo(TahunAjaran::class);
    }
    public function soals() {
        return $this->hasMany(Soal::class);
    }
    public function pesertaUjians() {
        return $this->hasMany(PesertaUjian::class);
    }
    
    public function getStatusAktifAttribute() {
        $now = now();
        if ($now >= $this->waktu_mulai && $now <= $this->waktu_selesai) {
            return 'Aktif';
        } elseif ($now > $this->waktu_selesai) {
            return 'Selesai';
        } else {
            return 'Belum Mulai';
        }
    }

}
