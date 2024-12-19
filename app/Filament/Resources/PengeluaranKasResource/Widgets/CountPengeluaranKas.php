<?php

namespace App\Filament\Resources\PengeluaranKasResource\Widgets;

use App\Models\PengeluaranKas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountPengeluaranKas extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Saldo Keluar', 'Rp ' . number_format(PengeluaranKas::sum('nominal'), 0, ',', '.'))
                ->description('Jumlah Total Semua Kas Keluar')
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
