<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Izin extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'jenis',
        'alasan',
        'date',
        'is_approved',
        'bukti'
    ];

    // Relasi dengan model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi dengan model Presensi, satu izin hanya bisa berkaitan dengan satu presensi
    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }
}
