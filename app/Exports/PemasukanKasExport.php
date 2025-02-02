<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\PemasukanKas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PemasukanKasExport implements FromArray, WithHeadings, WithColumnWidths
{
    protected $tanggalTagihan;

    public function __construct()
    {
        // Ambil semua tanggal dari tabel tagihan
        $this->tanggalTagihan = Tagihan::select('tanggal')
            ->distinct()
            ->pluck('tanggal')
            ->sort()
            ->toArray();
    }

    public function array(): array
    {
        // Ambil data siswa
        $siswaList = Siswa::all();

        // Ambil semua data pemasukan kas
        $pemasukanKasList = PemasukanKas::all();

        // Inisialisasi array hasil export
        $data = [];

        // Looping tiap siswa untuk menampilkan data pemasukan kas mereka
        foreach ($siswaList as $siswa) {
            $row = [
                'NISN' => $siswa->nisn,
                'Nama' => $siswa->nama,
            ];

            $totalPemasukan = 0;

            // Looping berdasarkan tanggal tagihan yang tersedia
            foreach ($this->tanggalTagihan as $tanggal) {
                // Filter data pemasukan kas untuk siswa dan tanggal tertentu
                $kasNominal = $pemasukanKasList->filter(function ($item) use ($siswa, $tanggal) {
                    return $item->siswa_id == $siswa->id && $item->tagihan->tanggal === $tanggal;
                })->pluck('nominal');

                // Hitung total nominal pemasukan kas
                $totalTanggal = $kasNominal->sum();

                // Tambahkan ke row
                $row[$tanggal] = $totalTanggal > 0 ? number_format($totalTanggal, 0, '.') : '';

                // Tambahkan nominal ke total pemasukan
                $totalPemasukan += $totalTanggal;
            }

            // Format total pemasukan
            $row['Jumlah'] = number_format($totalPemasukan, 0, '.');

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        // Buat heading dengan kolom tanggal dari tabel tagihan
        $headings = ['NISN', 'Nama'];

        foreach ($this->tanggalTagihan as $tanggal) {
            // Ubah format tanggal menjadi hari, tanggal bulan (tanpa tahun)
            $formattedDate = Carbon::parse($tanggal)->locale('id')->isoFormat('dddd D MMMM');
            $headings[] = $formattedDate;
        }

        // Tambahkan heading untuk jumlah
        $headings[] = 'Jumlah';

        return $headings;
    }

    public function columnWidths(): array
    {
        // Menentukan lebar kolom secara manual
        $columnWidths = [
            'A' => 20, // NISN
            'B' => 30, // Nama
        ];

        // Menentukan lebar untuk kolom tanggal berdasarkan posisi
        foreach ($this->tanggalTagihan as $index => $tanggal) {
            $columnWidths[chr(67 + $index)] = 20; // 67 adalah kode ASCII untuk 'C'
        }

        // Menentukan lebar untuk kolom 'Jumlah'
        $columnWidths['Z'] = 25; // Jumlah

        return $columnWidths;
    }


}
