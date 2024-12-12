<?php

namespace App\Filament\Resources\DebitTabunganResource\Pages;

use App\Filament\Resources\DebitTabunganResource;
use App\Filament\Resources\DebitTabunganResource\Widgets\StatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDebitTabungans extends ListRecords
{
    protected static string $resource = DebitTabunganResource::class;

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
