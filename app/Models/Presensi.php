<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'date',
        'jenis',
        'alasan',
        'time_in',
        'time_out',
        'bukti',
        'is_approved'
    ];

    // Relasi dengan model Siswa
    public function siswa() : BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    } 
}
