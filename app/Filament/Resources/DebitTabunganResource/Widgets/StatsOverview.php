<?php

namespace App\Filament\Resources\DebitTabunganResource\Widgets;

use App\Models\DebitTabungan;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Debit(Masuk) Tabungan', 'Rp ' . number_format(DebitTabungan::sum('nominal'), 0, ',', '.'))
            ->description('Jumlah total semua debit')
            ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
