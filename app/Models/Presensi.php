<?php

namespace App\Models;

use App\Models\Siswa;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;

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

    

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('bukti')
            ->useDisk('public');
    }

    // Relasi dengan model Siswa
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
