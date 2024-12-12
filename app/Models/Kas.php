<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $fillable =['jenis_transaksi','siswa_id','jumlah','keterangan',];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
