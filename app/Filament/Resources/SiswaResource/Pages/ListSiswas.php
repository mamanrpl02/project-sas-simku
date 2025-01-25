<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
            ->label('Export Siswa') // Label tombol export
            // ->icon('heroicon-o-download') // Ikon yang ditampilkan pada tombol
            ->url(route('siswa.export')) // URL menuju ke route export
            ->openUrlInNewTab(), // Agar link terbuka di tab baru
            Actions\CreateAction::make(),
        ];
    }


}
