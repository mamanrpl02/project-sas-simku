<?php

namespace App\Models;

use App\Models\Siswa;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class Presensi extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    protected static function booted()
    {
        // Hapus file 'bukti' ketika data presensi dihapus
        static::deleting(function ($presensi) {
            if ($presensi->bukti) {
                Storage::disk('public')->delete($presensi->bukti);
            }
        });
    }

    // Relasi dengan model Siswa
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
