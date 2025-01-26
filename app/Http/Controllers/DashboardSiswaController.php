<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Presensi;
use App\Models\PemasukanKas;
use Illuminate\Http\Request;
use App\Models\DebitTabungan;
use App\Models\KreditTabungan;
use App\Models\PengeluaranKas;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{

    public function index()
    {
        // Mendapatkan data siswa yang login
        $siswa = Auth::user();
        $pengeluaran = PengeluaranKas::orderBy('created_at', 'desc')->take(6)->get();

        $siswaId = auth()->user()->id; // Sesuaikan dengan sistem autentikasi Anda

        // Ambil semua tagihan yang belum dibayar, dengan pagination
        $tagihanBelumDibayar = Tagihan::whereDoesntHave('pemasukanKas', function ($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->paginate(1); // 1 data per halaman

        return view('siswa.index', compact('tagihanBelumDibayar', 'siswa', 'pengeluaran'));

        // Mengirimkan data siswa ke view
        return view('siswa.index', compact('siswa', 'pengeluaran'));
    }

    public function riwayat(Request $request)
    {
        $siswa = Auth::user();

        // Daftar bulan
        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Filter berdasarkan bulan yang dipilih
        $bulan = $request->get('bulan');
        $debitTabungan = $siswa->debitTabungans()
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $kreditTabungan = $siswa->kreditTabungans()
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->orderBy('created_at', 'desc')
            ->get();

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

        return view('siswa.transaksi', compact('siswa', 'transaksi', 'bulanList'));
    }


    public function pengeluaranKas(Request $request)
    {
        $siswa = Auth::user();

        // Mengambil bulan yang dipilih dari form, defaultnya adalah bulan saat ini
        $bulan = $request->get('bulan', now()->month);

        // Jika bulan yang dipilih adalah 'all', tampilkan semua data
        if ($bulan == 'all') {
            $pengeluaran = PengeluaranKas::orderBy('created_at', 'desc')->get();
            $pengeluaranKas = PengeluaranKas::sum('nominal');
        } else {
            // Filter pengeluaran berdasarkan bulan yang dipilih
            $pengeluaran = PengeluaranKas::whereMonth('created_at', $bulan)
                ->orderBy('created_at', 'desc')
                ->get();

            $pengeluaranKas = PengeluaranKas::whereMonth('created_at', $bulan)->sum('nominal');
        }

        // Menghitung total pemasukan
        $pemasukan = PemasukanKas::sum('nominal');
        $totalSaldo = $pemasukan - $pengeluaranKas;

        // Membuat list bulan untuk dropdown
        $bulanList = [ 
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view('siswa.catatanKas', compact('pengeluaran', 'pengeluaranKas', 'pemasukan', 'totalSaldo', 'bulanList'));
    }



    public function pemasukanKas(Request $request)
    {
        // Ambil data bulan dari request
        $bulan = $request->input('bulan', 'all'); // Default 'all' jika tidak ada filter bulan

        // Dapatkan list bulan untuk dropdown
        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Query pemasukanKas dengan filter bulan jika dipilih
        if ($bulan == 'all') {
            $pemasukanKas = PemasukanKas::with(['siswa', 'tagihan'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $pemasukanKas = PemasukanKas::with(['siswa', 'tagihan'])
                ->whereMonth('created_at', $bulan) // Filter berdasarkan bulan yang dipilih
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Hitung total pemasukan, pengeluaran dan saldo
        $pemasukan = PemasukanKas::sum('nominal');
        $pengeluaranKas = PengeluaranKas::sum('nominal');
        $totalSaldo = $pemasukan - $pengeluaranKas;

        // Kirim data ke view
        return view('siswa.pemasukanKas', compact('pemasukanKas', 'totalSaldo', 'pemasukan', 'bulanList'));
    }


    public function notifkas()
    {
        // return view('siswa.pemberitahuan');

        $siswa = Auth::user();
        $siswaId = auth()->user()->id; // Sesuaikan dengan sistem autentikasi Anda

        // Ambil semua tagihan
        $tagihanBelumDibayar = Tagihan::whereDoesntHave('pemasukanKas', function ($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->get();

        return view('siswa.pemberitahuan', compact('tagihanBelumDibayar', 'siswa'));
    }
}
