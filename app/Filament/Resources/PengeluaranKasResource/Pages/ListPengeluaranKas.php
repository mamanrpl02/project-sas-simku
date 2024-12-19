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
