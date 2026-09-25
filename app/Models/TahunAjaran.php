<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    //

    protected $guarded = [];
    public function ujians() {
        return $this->hasMany(Ujian::class);
    }

}
