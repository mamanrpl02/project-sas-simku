<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use App\Filament\Resources\KreditTabunganResource\Widgets\StatsOverview;
use App\Filament\Resources\KreditTabunganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKreditTabungans extends ListRecords
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export Kredit Tabungan') // Label tombol export
                // ->icon('heroicon-o-download') // Ikon yang ditampilkan pada tombol
                ->url(route('kredit.export')) // URL menuju ke route export
                ->openUrlInNewTab(), // Agar link terbuka di tab baru
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
