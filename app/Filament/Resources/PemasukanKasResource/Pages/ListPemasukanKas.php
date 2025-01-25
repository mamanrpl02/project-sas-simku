<?php

namespace App\Filament\Resources\PemasukanKasResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PemasukanKasResource;
use App\Filament\Resources\PemasukanKasResource\Widgets\CountPemasukanKas;
use App\Filament\Resources\PemasukanKasResource\Widgets\CountPengeluaranKas;

class ListPemasukanKas extends ListRecords
{
    protected static string $resource = PemasukanKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export Pemasukan Kas') // Label tombol export
                // ->icon('heroicon-o-download') // Ikon yang ditampilkan pada tombol
                ->url(route('pemasukanKas.export')) // URL menuju ke route export
                ->openUrlInNewTab(), // Agar link terbuka di tab baru
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CountPemasukanKas::class,
        ];
    }
}
