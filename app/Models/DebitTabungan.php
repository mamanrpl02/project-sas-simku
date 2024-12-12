<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitTabungan extends Model
{
    protected $fillable = [
        'siswa_id',
        'nominal',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
