<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model

{

    protected $table = 'siswas'; // Ini harus sama dengan nama tabel Anda di database


    public function debitTabungans()
    {
        return $this->hasMany(DebitTabungan::class);
    }
    public function kreditTabungans()
    {
        return $this->hasMany(KreditTabungan::class);
    }

    public function getSaldoAttribute()
    {
        // Hitung total debit dengan menggunakan relasi debitTabungans
        $debit = $this->debitTabungans()->sum('nominal');

        // Hitung total kredit dengan menggunakan relasi kreditTabungans
        $kredit = $this->kreditTabungans()->sum('nominal');

        // Menghitung saldo (debit - kredit)
        return $debit - $kredit;
    }
}
