<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SiswasImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Validators\ValidationException;


class SiswaImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new \App\Imports\SiswasImport();
        Excel::import($import, $request->file('file'));

        if ($import->failures()->isNotEmpty()) {
            foreach ($import->failures() as $failure) {
                foreach ($failure->errors() as $error) {
                    \Filament\Notifications\Notification::make()
                        ->title('Gagal Import')
                        ->body("Baris {$failure->row()} kolom {$failure->attribute()} : {$error}")
                        ->danger()
                        ->send();
                }
            }
        } else {
            \Filament\Notifications\Notification::make()
                ->title('Import Berhasil')
                ->body('Semua data siswa berhasil diimport!')
                ->success()
                ->send();
        }

        return redirect()->back();
    }
}
