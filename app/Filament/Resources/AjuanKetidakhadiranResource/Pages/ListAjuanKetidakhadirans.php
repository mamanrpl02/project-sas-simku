<?php

namespace App\Filament\Resources\AjuanKetidakhadiranResource\Pages;

use App\Filament\Resources\AjuanKetidakhadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAjuanKetidakhadirans extends ListRecords
{
    protected static string $resource = AjuanKetidakhadiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
