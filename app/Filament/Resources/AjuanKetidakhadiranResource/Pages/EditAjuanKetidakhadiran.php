<?php

namespace App\Filament\Resources\AjuanKetidakhadiranResource\Pages;

use App\Filament\Resources\AjuanKetidakhadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAjuanKetidakhadiran extends EditRecord
{
    protected static string $resource = AjuanKetidakhadiranResource::class;

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
