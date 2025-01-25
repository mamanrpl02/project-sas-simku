<?php

namespace App\Filament\Resources\PengeluaranKasResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PengeluaranKasResource;
use App\Filament\Resources\PemasukanKasResource\Widgets\CountPemasukanKas;
use App\Filament\Resources\PengeluaranKasResource\Widgets\CountPengeluaranKas;

class ListPengeluaranKas extends ListRecords
{
    protected static string $resource = PengeluaranKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export Pengeluaran Kas') // Label tombol export
                // ->icon('heroicon-o-download') // Ikon yang ditampilkan pada tombol
                ->url(route('pengeluaranKas.export')) // URL menuju ke route export
                ->openUrlInNewTab(), // Agar link terbuka di tab baru
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CountPengeluaranKas::class,
        ];
    }
}
