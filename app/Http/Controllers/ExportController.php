<?php

namespace App\Http\Controllers;

use App\Exports\DebitTabunganExport;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{


    public function exportPresensi(Request $request)
    {
        // Ambil bulan dari request atau gunakan bulan saat ini jika tidak ada
        $bulan = $request->input('bulan', now()->month);

        // Ekspor presensi berdasarkan bulan yang dipilih
        return Excel::download(new PresensiExport($bulan), 'Presensi.xlsx');
    }

    public function exportDebit(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        return Excel::download(new DebitTabunganExport($bulan), 'debit-tabungan-' . $bulan . '.xlsx');
    }
}
