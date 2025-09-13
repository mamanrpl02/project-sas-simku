<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SiswasImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Siswa([
            'nisn'          => $row['nisn'],
            'nama'          => $row['nama'],
            'jenis_kelamin' => strtolower($row['jenis_kelamin']),
            'alamat'        => $row['alamat'],
            'email'         => $row['email'],
            'password'      => 'simku1234', // otomatis di-hash lewat mutator
        ]);
    }

    public function rules(): array
    {
        return [
            'nisn' => [
                'required',
                'digits_between:9,10', // minimal 5 digit, maksimal 20 digit
                'regex:/^[0-9]+$/',    // hanya angka
                'unique:siswas,nisn',
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => [
                'required',
                'in:l,p', // hanya l / p
            ],
            'alamat' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:siswas,email',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            // Kolom NISN
            'nisn.required'       => 'Kolom NISN wajib diisi.',
            'nisn.digits_between' => 'Kolom NISN harus terdiri dari 9 sampai 10 digit.',
            'nisn.regex'          => 'Kolom NISN hanya boleh berisi angka.',
            'nisn.unique'         => 'Kolom NISN sudah ada di database.',

            // Kolom Nama
            'nama.required' => 'Kolom Nama wajib diisi.',
            'nama.string'   => 'Kolom Nama harus berupa teks.',
            'nama.max'      => 'Kolom Nama maksimal 255 karakter.',

            // Kolom Jenis Kelamin
            'jenis_kelamin.required' => 'Kolom Jenis Kelamin wajib diisi.',
            'jenis_kelamin.in'       => 'Kolom Jenis Kelamin hanya boleh "l" atau "p".',

            // Kolom Alamat
            'alamat.required' => 'Kolom Alamat wajib diisi.',
            'alamat.string'   => 'Kolom Alamat harus berupa teks.',
            'alamat.max'      => 'Kolom Alamat maksimal 255 karakter.',

            // Kolom Email
            'email.required' => 'Kolom Email wajib diisi.',
            'email.email'    => 'Kolom Email harus dalam format email valid.',
            'email.unique'   => 'Kolom Email sudah digunakan.',
        ];
    }
}
