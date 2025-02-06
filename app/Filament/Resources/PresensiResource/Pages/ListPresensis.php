<?php

namespace App\Filament\Resources\PresensiResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PresensiResource;
use Filament\Forms\Components\Select; // Pastikan ini sudah diimpor dengan benar
use Filament\Actions\Action;


class ListPresensis extends ListRecords
{
    protected static string $resource = PresensiResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\Action::make('export')
                ->label('Export Presensi')
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
                    return redirect()->route('presensi.export', ['bulan' => $bulan])->with('bulan', $bulan);
                })
                ->modalHeading('Pilih Bulan untuk Export'),

            Action::make('Kirim Notif')
                ->url(route('send.absen'))
                ->openUrlInNewTab(),

            Actions\CreateAction::make(),
        ];
    }
}
