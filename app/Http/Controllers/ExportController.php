<?php

namespace App\Http\Controllers;

use App\Models\PemasukanKas;
use Illuminate\Http\Request;
use App\Exports\PresensiExport;
use App\Exports\PemasukanKasExport;
use App\Exports\DebitTabunganExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KreditTabunganExport;

class ExportController extends Controller
{


    public function exportPresensi(Request $request)
    {

        $bulan = intval($request->input('bulan', now()->month));
        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        // Ekspor presensi berdasarkan bulan yang dipilih
        return Excel::download(new PresensiExport($bulan), 'Presensi.xlsx');
    }

    public function exportDebit(Request $request)
    {

        $bulan = intval($request->input('bulan', now()->month));
        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        return Excel::download(new DebitTabunganExport($bulan), 'debit-tabungan-' . $bulan . '.xlsx');
    }

    public function exportKredit(Request $request)
    {

        $bulan = intval($request->input('bulan', now()->month));
        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }
        return Excel::download(new KreditTabunganExport($bulan), 'kredit-tabungan-' . $bulan . '.xlsx');
    }

    public function exportPemasukanKas(Request $request)
    {

        $bulan = intval($request->input('bulan', now()->month));
        if ($bulan < 1 || $bulan > 12) {
            abort(400, 'Bulan tidak valid');
        }

        // Pastikan menggunakan PemasukanKasExport, bukan PemasukanKas
        return Excel::download(new PemasukanKasExport($bulan), 'pemasukan-kas-' . $bulan . '.xlsx');
    }
}
