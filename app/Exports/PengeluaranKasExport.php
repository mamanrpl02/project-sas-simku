<?php

namespace App\Exports;

use App\Models\PengeluaranKas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Carbon\Carbon;

class PengeluaranKasExport implements FromArray, WithHeadings, WithColumnWidths
{
    public function array(): array
    {
        // Ambil semua data pengeluaran kas
        $pengeluaranKasList = PengeluaranKas::all();

        // Inisialisasi array hasil export
        $data = [];
        $totalNominal = 0;

        // Looping untuk setiap data pengeluaran kas
        foreach ($pengeluaranKasList as $pengeluaranKas) {
            $row = [
                'Judul' => $pengeluaranKas->judul,
                'Keterangan' => $pengeluaranKas->keterangan,
                // Format tanggal menjadi "Hari, Tanggal Bulan"
                'Tanggal' => Carbon::parse($pengeluaranKas->tanggal)->locale('id')->isoFormat('dddd D MMMM YYYY'),
                'Nominal' => number_format($pengeluaranKas->nominal, 0, '.'),
            ];

            $totalNominal += $pengeluaranKas->nominal;
            $data[] = $row;
        }

        // Tambahkan total di baris akhir
        $data[] = [
            'Judul' => 'Total',
            'Keterangan' => '',
            'Tanggal' => '',
            'Nominal' => number_format($totalNominal, 0, '.'),
        ];

        return $data;
    }

    public function headings(): array
    {
        // Definisikan heading untuk export
        return [
            'Judul',
            'Keterangan',
            'Tanggal',
            'Nominal',
        ];
    }

    public function columnWidths(): array
    {
        // Menentukan lebar kolom secara manual
        return [
            'A' => 30, // Judul
            'B' => 50, // Keterangan
            'C' => 20, // Tanggal
            'D' => 15, // Nominal
        ];
    }
}
