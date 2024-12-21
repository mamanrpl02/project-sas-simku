<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\PemasukanKas;
use Illuminate\Http\Request;
use App\Models\PengeluaranKas;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{

    public function index()
    {
        // Mendapatkan data siswa yang login
        $siswa = Auth::user();

        $pengeluaran = PengeluaranKas::all();

        // Mengirimkan data siswa ke view
        return view('siswa.index', compact('siswa','pengeluaran'));
    }

    public function riwayat()
    {
        $siswa = Auth::user();

        // Mendapatkan semua transaksi debit dan kredit siswa
        $debitTabungan = $siswa->debitTabungans()->orderBy('created_at', 'desc')->get();
        $kreditTabungan = $siswa->kreditTabungans()->orderBy('created_at', 'desc')->get();

        // Menggabungkan semua transaksi untuk tabel riwayat
        $transaksi = $debitTabungan->map(function ($debit) {
            return [
                'tanggal' => $debit->created_at,
                'nominal' => $debit->nominal,
                'keterangan' => 'Debit', // Menandakan ini transaksi debit
            ];
        })->merge($kreditTabungan->map(function ($kredit) {
            return [
                'tanggal' => $kredit->created_at,
                'nominal' => $kredit->nominal,
                'keterangan' => 'Kredit', // Menandakan ini transaksi kredit
            ];
        }))->sortByDesc('tanggal'); // Urutkan transaksi berdasarkan tanggal

        return view('siswa.transaksi', compact('siswa', 'transaksi'));
    }

    public function pengeluaranKas()
    {
        $siswa = Auth::user();
        $pengeluaran = PengeluaranKas::all();

        $pemasukan = PemasukanKas::sum('nominal');
        $pengeluaranKas = PengeluaranKas::sum('nominal');
        $totalSaldo = $pemasukan - $pengeluaranKas;

        return view('siswa.catatanKas', compact('pengeluaran','pengeluaranKas','pemasukan','totalSaldo'));
    }

    public function pemasukanKas()
    {
        $pemasukanKas = PemasukanKas::with(['siswa', 'tagihan'])->get(); // Ambil data dengan relasi

        $pemasukan = PemasukanKas::sum('nominal');
        $pengeluaranKas = PengeluaranKas::sum('nominal');
        $totalSaldo = $pemasukan - $pengeluaranKas;



        return view('siswa.pemasukanKas', compact('pemasukanKas','totalSaldo','pemasukan')); // Ganti 'nama_view' dengan nama file Blade
    }

    public function notifkas()
    {
        $siswa = Auth::user();
        return view('siswa.pemberitahuan');
    }
}
