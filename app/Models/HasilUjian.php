<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    //

    protected $guarded = [];
    public function pesertaUjian() {
        return $this->belongsTo(PesertaUjian::class);
    }

}
