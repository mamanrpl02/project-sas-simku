<?php

namespace App\Filament\Resources\DebitTabunganResource\Pages;

use App\Filament\Resources\DebitTabunganResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDebitTabungan extends CreateRecord
{
    protected static string $resource = DebitTabunganResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
