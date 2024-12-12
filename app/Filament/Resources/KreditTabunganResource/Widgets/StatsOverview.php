<?php

namespace App\Filament\Resources\KreditTabunganResource\Widgets;

use App\Models\KreditTabungan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kredit (Keluar)', 'Rp ' . number_format(KreditTabungan::sum('nominal'), 0, ',', '.'))
                ->description('Jumlah total semua kredit')
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
