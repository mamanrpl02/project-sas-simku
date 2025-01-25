<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\DebitTabungan;
use App\Models\KreditTabungan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KreditTabunganExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
        $kreditTabunganList = KreditTabungan::whereMonth('created_at', $this->bulan)->get();

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

            $totalKredit = 0;

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $tanggal = Carbon::create(null, $this->bulan, $i)->toDateString();

                $kreditNominal = $kreditTabunganList->filter(function ($item) use ($siswa, $tanggal) {
                    return $item->siswa_id === $siswa->id && $item->created_at->toDateString() === $tanggal;
                })->pluck('nominal');

                $formattedkredit = $kreditNominal->map(fn($val) => $this->format_rupiah($val));

                $row['Hari ' . $i] = $formattedkredit->isNotEmpty()
                    ? $formattedkredit->implode(', ')
                    : '';

                // Tambahkan nominal ke total debit (tanpa perkalian 1000, tetap menggunakan nilai asli)
                $totalKredit += $kreditNominal->sum();
            }

            // Format total debit dengan 1000 untuk tampilan
            $row['Total Kredit'] = number_format($totalKredit, 0, '.');

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
        $headings[] = 'Total Kredit';

        return $headings;
    }
}
