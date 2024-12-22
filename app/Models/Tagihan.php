<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function pemasukanKas()
    {
        return $this->hasMany(PemasukanKas::class, 'tagihan_id');
    }
}
