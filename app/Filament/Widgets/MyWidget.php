<?php

namespace App\Filament\Widgets;

use App\Models\DebitTabungan;
use App\Models\KreditTabungan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MyWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Debit Keseluruhan', 'Rp ' . number_format(DebitTabungan::sum('nominal'), 0, ',', '.')),
            Stat::make('Total Kredit Keseluruhan', 'Rp ' . number_format(KreditTabungan::sum('nominal'), 0, ',', '.')),
            Stat::make('Total Saldo Keseluruhan', function () {
                // Hitung total debit
                $totalDebit = DebitTabungan::sum('nominal');

                // Hitung total kredit
                $totalKredit = KreditTabungan::sum('nominal');

                // Hitung saldo keseluruhan
                $totalSaldo = $totalDebit - $totalKredit;

                return 'Rp ' . number_format($totalSaldo, 0, ',', '.');
            }),
        ];
    }
}
