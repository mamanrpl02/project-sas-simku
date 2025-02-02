<?php

namespace App\Http\Controllers;

use App\Models\PemasukanKas;
use Illuminate\Http\Request;
use App\Exports\PresensiExport;
use App\Exports\PemasukanKasExport;
use App\Exports\DebitTabunganExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KreditTabunganExport;
use App\Exports\PengeluaranKasExport;
use App\Exports\SiswaExport;
use App\Livewire\Presensi;
use App\Models\PengeluaranKas;

class ExportController extends Controller
{

    public function exportPresensi(Request $request, $bulan = null)
    {
        // Jika bulan tidak dikirimkan dari form, gunakan bulan saat ini
        $bulan = $bulan ?? intval($request->input('bulan', now()->month));

        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        return Excel::download(new PresensiExport($bulan), 'presensi-bulan-' . $bulan . '.xlsx');
    }


    public function exportDebit(Request $request, $bulan = null)
    {
        // dd($request->all());  // Melihat semua data yang dikirim
        // Jika bulan tidak dikirimkan dari form, gunakan bulan saat ini
        $bulan = $bulan ?? intval($request->input('bulan', now()->month));

        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        return Excel::download(new DebitTabunganExport($bulan), 'debit-tabungan-bulan-' . $bulan . '.xlsx');
    }

    public function exportKredit(Request $request, $bulan = null)
    {

        $bulan = $bulan ?? intval($request->input('bulan', now()->month));

        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        return Excel::download(new KreditTabunganExport($bulan), 'kredit-tabungan-bulan-' . $bulan . '.xlsx');
    }

    public function exportPemasukanKas()
    {
        return Excel::download(new PemasukanKasExport(), 'pemasukan-kas.xlsx');
    }

    public function exportpengeluaranKas()
    {
        return Excel::download(new PengeluaranKasExport(), 'pengeluaran-kas.xlsx');
    }


    public function exportsiswa()
    {
        return Excel::download(new SiswaExport(), 'siswa.xlsx');
    }
}
