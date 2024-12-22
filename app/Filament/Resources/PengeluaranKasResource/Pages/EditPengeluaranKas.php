<?php

namespace App\Filament\Resources\PengeluaranKasResource\Pages;

use App\Filament\Resources\PengeluaranKasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengeluaranKas extends EditRecord
{
    protected static string $resource = PengeluaranKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
