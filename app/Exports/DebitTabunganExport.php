<?php

namespace App\Exports;

use App\Models\DebitTabungan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DebitTabunganExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return DebitTabungan::query()
            ->join('siswas', 'debit_tabungans.siswa_id', '=', 'siswas.id')
            ->select('siswas.nama', 'siswas.nisn', 'debit_tabungans.nominal', 'debit_tabungans.created_at');
    }


    public function headings(): array
    {
        // Menentukan heading pada file Excel
        return [
            'Nama Siswa',
            'NISN',
            'Nominal Debit',
            'Tanggal'
        ];
    }
}
