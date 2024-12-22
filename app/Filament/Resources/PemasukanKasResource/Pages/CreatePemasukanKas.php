<?php

namespace App\Filament\Resources\PemasukanKasResource\Pages;

use App\Filament\Resources\PemasukanKasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePemasukanKas extends CreateRecord
{
    protected static string $resource = PemasukanKasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
