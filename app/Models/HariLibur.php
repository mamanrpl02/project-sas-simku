<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HariLibur extends Model
{
    use HasFactory;


    protected $fillable = [
        'tanggal',
        'keterangan',
    ];
}
