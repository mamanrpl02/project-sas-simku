<?php
namespace App\Exports;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PresensiExport implements FromArray, WithHeadings, WithColumnWidths
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function array(): array
    {
        // Ambil data siswa
        $siswaList = Siswa::all();

        // Ambil data presensi berdasarkan bulan yang di-approve saja
        $presensiList = Presensi::whereMonth('date', $this->bulan)
            ->where('is_approved', 1) // Sesuaikan dengan nama kolom yang benar
            ->get();

        // Inisialisasi array hasil export
        $data = [];

        // Looping tiap siswa untuk menampilkan data presensi mereka
        foreach ($siswaList as $siswa) {
            $row = [
                'NIS' => $siswa->nisn,
                'Nama' => $siswa->nama,
            ];

            // Inisialisasi variabel penghitung
            $hadir = 0;
            $sakit = 0;
            $izin = 0;
            $alpha = 0;

            // Loop untuk tiap hari dalam bulan tersebut
            for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {
                $tanggal = Carbon::create(null, $this->bulan, $i)->format('Y-m-d');

                // Cek apakah siswa hadir pada tanggal tersebut dengan approved = 1
                $presensi = $presensiList->where('siswa_id', $siswa->id)
                    ->where('date', $tanggal)
                    ->first();

                // Tentukan jenis presensi (H, A, S, I)
                if ($presensi) {
                    $row['Hari ' . $i] = $presensi->jenis;

                    // Tambahkan ke penghitung berdasarkan jenis presensi
                    if ($presensi->jenis == 'H') {
                        $hadir++;
                    } elseif ($presensi->jenis == 'S') {
                        $sakit++;
                    } elseif ($presensi->jenis == 'I') {
                        $izin++;
                    } elseif ($presensi->jenis == 'A') {
                        $alpha++;
                    }
                } else {
                    // Jika tidak ada data presensi yang diapprove, biarkan kosong
                    $row['Hari ' . $i] = '';
                }
            }

            // Tambahkan kolom hasil perhitungan di akhir
            $row['Total Hadir'] = $hadir;
            $row['Total Sakit'] = $sakit;
            $row['Total Izin'] = $izin;
            $row['Total Alpha'] = $alpha;

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        // Buat heading dengan kolom tanggal
        $headings = ['NIS', 'Nama'];
        for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {
            $headings[] = $i;
        }

        // Tambahkan heading untuk total kehadiran, sakit, izin, dan alpha
        $headings[] = 'Total Hadir';
        $headings[] = 'Total Sakit';
        $headings[] = 'Total Izin';
        $headings[] = 'Total Alpha';

        return $headings;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // NIS
            'B' => 30, // Nama
        ];
    }
}
