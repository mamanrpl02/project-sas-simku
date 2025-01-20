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

    // Relasi dengan model Izin, satu presensi bisa memiliki satu izin (di tanggal yang sama)
    public function izin()
    {
        return $this->hasOne(Izin::class, 'siswa_id', 'siswa_id')
            ->where('date', $this->date); // Cek jika izin pada tanggal yang sama
    }
}
