<?php

namespace App\Filament\Exports;

use App\Models\DebitTabungan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DebitTabunganExporter extends Exporter
{
    protected static ?string $model = DebitTabungan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('siswa.nama') // Jika ada relasi dengan model siswa
                ->label('Nama Siswa'),
            ExportColumn::make('nominal')
                ->label('Nominal'),
            ExportColumn::make('created_at')
                ->label('Tanggal Dibuat'),
            ExportColumn::make('updated_at')
                ->label('Tanggal Diupdate'),
        ];
    }


    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your debit tabungan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
