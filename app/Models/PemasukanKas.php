<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemasukanKas extends Model
{
    protected $fillable = [
        'siswa_id',
        'tagihan_id',
    ];


    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    } 
}
