<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\DebitTabungan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DebitTabunganExport implements FromArray, WithHeadings
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    function format_rupiah($angka) {

        return number_format($angka, 0 , '.');
    }

    public function array(): array
    {
        // Ambil data siswa
        $siswaList = Siswa::all();

        // Ambil data debit tabungan berdasarkan bulan
        $debitTabunganList = DebitTabungan::whereMonth('created_at', $this->bulan)->get();

        // Inisialisasi array hasil export
        $data = [];

        // Tentukan jumlah hari dalam bulan
        $daysInMonth = Carbon::create(null, $this->bulan, 1)->daysInMonth;

        // Looping tiap siswa untuk menampilkan data debit tabungan mereka
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

                // Tambahkan nominal ke total debit (tanpa perkalian 1000, tetap menggunakan nilai asli)
                $totalDebit += $debitNominal->sum();
            }

            // Format total debit dengan 1000 untuk tampilan
            $row['Total Debit'] = number_format($totalDebit, 0, '.');

            $data[] = $row;
        }

        return $data;
    }




    public function headings(): array
    {
        // Buat heading dengan kolom tanggal
        $headings = ['NIS', 'Nama'];
        $daysInMonth = Carbon::create(null, $this->bulan, 1)->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $headings[] = 'Hari ' . $i;
        }

        // Tambahkan heading untuk total debit
        $headings[] = 'Total Debit';

        return $headings;
    }
}
