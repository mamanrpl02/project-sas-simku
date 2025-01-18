<?php

namespace App\Models;

use Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Gunakan Authenticatable sebagai dasar

class Siswa extends Authenticatable

{

    protected $table = 'siswas'; // Ini harus sama dengan nama tabel Anda di database

    protected $fillable = [
        'nisn',
        'nama',
        'jenis_kelamin',
        'alamat',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token']; // Kolom yang perlu disembunyikan
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Model Hook untuk Hash Password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

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

    // Relasi ke TagihanKas
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Relasi dengan Presensi
    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    } 

    // Relasi dengan izin
    public function izins()
    {
        return $this->hasMany(Izin::class);
    }
}
