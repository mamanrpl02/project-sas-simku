<?php

namespace App\Filament\Resources\PresensiResource\Pages;

use App\Filament\Resources\PresensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresensis extends ListRecords
{
    protected static string $resource = PresensiResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\Action::make('export')
            ->label('Export Presensi') // Label tombol export
            // ->icon('heroicon-o-download') // Ikon yang ditampilkan pada tombol
            ->url(route('presensi.export')) // URL menuju ke route export
            ->openUrlInNewTab(), // Agar link terbuka di tab baru
            Actions\CreateAction::make(),
        ];
    }
}
