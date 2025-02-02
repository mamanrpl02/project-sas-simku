<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\DebitTabungan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class DebitTabunganExport implements FromArray, WithHeadings, WithColumnWidths
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    function format_rupiah($angka) {
        return number_format($angka, 0, '.');
    }

    public function array(): array
    {
        $siswaList = Siswa::all();
        $debitTabunganList = DebitTabungan::whereMonth('created_at', $this->bulan)->get();

        $data = [];
        $daysInMonth = Carbon::create(null, $this->bulan, 1)->daysInMonth;
        $grandTotal = 0;

        foreach ($siswaList as $siswa) {
            $row = [
                'NIS' => $siswa->nisn,
                'Nama' => $siswa->nama,
            ];

            $totalDebit = 0;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $tanggal = Carbon::create(null, $this->bulan, $i)->toDateString();

                $debitNominal = $debitTabunganList->filter(function ($item) use ($siswa, $tanggal) {
                    return $item->siswa_id === $siswa->id && $item->created_at->toDateString() === $tanggal;
                })->pluck('nominal');

                $formattedDebit = $debitNominal->map(fn($val) => $this->format_rupiah($val));

                $row['Hari ' . $i] = $formattedDebit->isNotEmpty()
                    ? $formattedDebit->implode(', ')
                    : '';

                $totalDebit += $debitNominal->sum();
            }

            $row['Total Debit'] = number_format($totalDebit, 0, '.');
            $grandTotal += $totalDebit;
            $data[] = $row;
        }

        // Tambahkan baris total di bagian akhir
        $totalRow = [
            'NIS' => '',
            'Nama' => 'Total Seluruh Debit'
        ];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $totalRow['Hari ' . $i] = ''; // Kosongkan kolom hari
        }

        $totalRow['Total Debit'] = number_format($grandTotal, 0, '.');
        $data[] = $totalRow;

        return $data;
    }

    public function headings(): array
    {
        $headings = ['NIS', 'Nama'];
        $daysInMonth = Carbon::create(null, $this->bulan, 1)->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $headings[] = 'Hari ' . $i;
        }

        $headings[] = 'Total Debit';

        return $headings;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
        ];
    }
}
