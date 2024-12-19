<?php

namespace App\Filament\Resources\PemasukanKasResource\Pages;

use App\Filament\Resources\PemasukanKasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPemasukanKas extends EditRecord
{
    protected static string $resource = PemasukanKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
