<?php

namespace App\Filament\Resources\DebitTabunganResource\Pages;

use App\Filament\Resources\DebitTabunganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDebitTabungan extends EditRecord
{
    protected static string $resource = DebitTabunganResource::class;

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
