<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\KreditTabungan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class KreditTabunganExport implements FromArray, WithHeadings, WithColumnWidths
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    function format_rupiah($angka)
    {
        return number_format($angka, 0, '.');
    }

    public function array(): array
    {
        $siswaList = Siswa::all();
        $kreditTabunganList = KreditTabungan::whereMonth('created_at', $this->bulan)->get();

        $data = [];
        $daysInMonth = Carbon::create(null, $this->bulan, 1)->daysInMonth;
        $grandTotal = 0;

        foreach ($siswaList as $siswa) {
            $row = [
                'NIS' => $siswa->nisn,
                'Nama' => $siswa->nama,
            ];

            $totalKredit = 0;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $tanggal = Carbon::create(null, $this->bulan, $i)->toDateString();

                $kreditNominal = $kreditTabunganList->filter(function ($item) use ($siswa, $tanggal) {
                    return $item->siswa_id === $siswa->id && $item->created_at->toDateString() === $tanggal;
                })->pluck('nominal');

                $formattedKredit = $kreditNominal->map(fn($val) => $this->format_rupiah($val));

                $row['Hari ' . $i] = $formattedKredit->isNotEmpty()
                    ? $formattedKredit->implode(', ')
                    : '';

                $totalKredit += $kreditNominal->sum();
            }

            $row['Total Kredit'] = number_format($totalKredit, 0, '.');
            $grandTotal += $totalKredit;
            $data[] = $row;
        }

        // Tambahkan baris total di bagian akhir
        $totalRow = [
            'NIS' => '',
            'Nama' => 'Total Seluruh Kredit'
        ];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $totalRow['Hari ' . $i] = ''; // Kosongkan kolom hari
        }

        $totalRow['Total Kredit'] = number_format($grandTotal, 0, '.');
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

        $headings[] = 'Total Kredit';

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
