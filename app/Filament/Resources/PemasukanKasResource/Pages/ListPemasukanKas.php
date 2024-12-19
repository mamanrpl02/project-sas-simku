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
