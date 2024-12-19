<?php

namespace App\Filament\Resources\PemasukanKasResource\Widgets;

use App\Models\PemasukanKas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountPemasukanKas extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Saldo Masuk', 'Rp ' . number_format(PemasukanKas::sum('nominal'), 0, ',', '.'))
                ->description('Jumlah Total Semua Kas Masuk')
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
