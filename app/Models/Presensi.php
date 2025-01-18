<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory;


    protected $fillable = ['siswa_id', 'date', 'time_in', 'time_out'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
