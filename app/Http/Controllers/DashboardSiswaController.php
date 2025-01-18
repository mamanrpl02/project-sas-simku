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
        $pengeluaran = PengeluaranKas::orderBy('created_at', 'desc')->get();

        $siswaId = auth()->user()->id; // Sesuaikan dengan sistem autentikasi Anda

        // Ambil semua tagihan yang belum dibayar, dengan pagination
        $tagihanBelumDibayar = Tagihan::whereDoesntHave('pemasukanKas', function ($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->paginate(1); // 1 data per halaman

        return view('siswa.index', compact('tagihanBelumDibayar', 'siswa', 'pengeluaran'));

        // Mengirimkan data siswa ke view
        return view('siswa.index', compact('siswa', 'pengeluaran'));
    }



    public function presensi(Request $request)
    {
        // Mendapatkan data siswa yang sedang login
        $siswa = Auth::user();

        // Daftar bulan
        $bulanList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Mengambil data presensi dan mengurutkannya berdasarkan tanggal terbaru
        $shortData = Presensi::orderBy('date', 'desc')->get();

        // Ambil bulan yang dipilih atau bulan sekarang
        $bulanDipilih = $request->input('bulan', Carbon::now()->format('m'));

        // Ambil data presensi siswa berdasarkan bulan yang dipilih, urutkan dari terbaru ke lama
        $presensiList = Presensi::where('siswa_id', $siswa->id)
            ->whereMonth('date', $bulanDipilih)
            ->orderBy('date', 'desc') // Mengurutkan dari yang terbaru ke yang lama
            ->get();

        // Ambil data izin siswa berdasarkan bulan yang dipilih
        $izinList = Izin::where('siswa_id', $siswa->id)
            ->whereMonth('date', $bulanDipilih)
            ->get();

        // Gabungkan data izin ke dalam data presensi berdasarkan tanggal yang sama
        foreach ($presensiList as $presensi) {
            $izin = $izinList->firstWhere('date', $presensi->date);
            $presensi->izin = $izin; // Menambahkan data izin ke dalam objek presensi
        }

        // Return ke view dengan data presensi dan izin yang sudah digabungkan
        return view('siswa.presensi', compact('siswa', 'presensiList', 'bulanList', 'shortData'));
    }



    public function pengajuan()
    {
        // Mendapatkan data siswa yang login
        $siswa = Auth::user();
        // $siswaId = auth()->user()->id; // Sesuaikan dengan sistem autentikasi Anda

        // Mengirimkan data siswa ke view
        return view('siswa.pengajuan', compact('siswa'));
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
        $pengeluaran = PengeluaranKas::orderBy('created_at', 'desc')->get(); // Urutkan berdasarkan 'created_at' terbaru

        $pemasukan = PemasukanKas::sum('nominal');
        $pengeluaranKas = PengeluaranKas::sum('nominal');
        $totalSaldo = $pemasukan - $pengeluaranKas;

        return view('siswa.catatanKas', compact('pengeluaran', 'pengeluaranKas', 'pemasukan', 'totalSaldo'));
    }

    public function pemasukanKas()
    {
        // Ambil data pemasukan kas dengan relasi 'siswa' dan 'tagihan', diurutkan berdasarkan 'created_at' (terbaru)
        $pemasukanKas = PemasukanKas::with(['siswa', 'tagihan'])
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan 'created_at' terbaru
            ->get();

        // Total pemasukan dan pengeluaran
        $pemasukan = PemasukanKas::sum('nominal');
        $pengeluaranKas = PengeluaranKas::sum('nominal');
        $totalSaldo = $pemasukan - $pengeluaranKas;

        return view('siswa.pemasukanKas', compact('pemasukanKas', 'totalSaldo', 'pemasukan'));
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
