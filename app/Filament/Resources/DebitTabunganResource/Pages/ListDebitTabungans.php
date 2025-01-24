<?php

namespace App\Filament\Resources\DebitTabunganResource\Pages;

use App\Filament\Resources\DebitTabunganResource;
use App\Filament\Resources\DebitTabunganResource\Widgets\StatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDebitTabungans extends ListRecords
{
    protected static string $resource = DebitTabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Export Debit Tabungan') // Label tombol export
                // ->icon('heroicon-o-download') // Ikon yang ditampilkan pada tombol
                ->url(route('debit.export')) // URL menuju ke route export
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
