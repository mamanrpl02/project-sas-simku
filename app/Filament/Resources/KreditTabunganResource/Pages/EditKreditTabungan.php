<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use App\Filament\Resources\KreditTabunganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKreditTabungan extends EditRecord
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
