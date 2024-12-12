<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use App\Filament\Resources\KreditTabunganResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKreditTabungan extends CreateRecord
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
