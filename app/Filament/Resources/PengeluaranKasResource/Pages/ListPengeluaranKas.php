<?php

namespace App\Filament\Resources\PengeluaranKasResource\Pages;

use App\Filament\Resources\PengeluaranKasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengeluaranKas extends ListRecords
{
    protected static string $resource = PengeluaranKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
