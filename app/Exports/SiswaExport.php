<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class SiswaExport implements FromArray, WithHeadings, WithColumnWidths
{
    public function array(): array
    {
        // Ambil semua data siswa
        $siswaList = Siswa::all();

        // Inisialisasi array hasil export
        $data = [];

        // Looping untuk setiap data siswa
        foreach ($siswaList as $siswa) {
            $row = [
                'NISN' => $siswa->nisn,
                'Nama' => $siswa->nama,
                'Jenis Kelamin' => $siswa->jenis_kelamin,
                'Alamat' => $siswa->alamat,
                'Email' => $siswa->email,
            ];

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        // Definisikan heading untuk export
        return [
            'NISN',
            'Nama',
            'Jenis Kelamin',
            'Alamat',
            'Email',
        ];
    }

    public function columnWidths(): array
    {
        // Menentukan lebar kolom secara manual
        return [
            'A' => 15, // NISN
            'B' => 30, // Nama
            'C' => 15, // Jenis Kelamin
            'D' => 50, // Alamat
            'E' => 30, // Email
        ];
    }
}

