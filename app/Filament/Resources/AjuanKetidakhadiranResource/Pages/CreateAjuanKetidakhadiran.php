<?php

namespace App\Filament\Resources\AjuanKetidakhadiranResource\Pages;

use App\Filament\Resources\AjuanKetidakhadiranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAjuanKetidakhadiran extends CreateRecord
{
    protected static string $resource = AjuanKetidakhadiranResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
