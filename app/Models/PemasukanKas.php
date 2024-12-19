<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemasukanKas extends Model
{
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
