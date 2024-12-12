<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use App\Filament\Resources\KreditTabunganResource\Widgets\StatsOverview;
use App\Filament\Resources\KreditTabunganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKreditTabungans extends ListRecords
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
