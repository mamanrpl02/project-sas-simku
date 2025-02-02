<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\KreditTabunganResource;
use App\Filament\Resources\KreditTabunganResource\Widgets\StatsOverview;

class ListKreditTabungans extends ListRecords
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
            ->label('Export Kredit')
            ->form([
                Select::make('bulan')
                    ->label('Pilih Bulan')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->required(),
            ])
            ->action(function (array $data) {
                $bulan = $data['bulan'];
                // Redirect POST ke route export
                return redirect()->route('kredit.export', ['bulan' => $bulan]);
            }),

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
