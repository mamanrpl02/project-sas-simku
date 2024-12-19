<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
