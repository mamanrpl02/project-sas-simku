<?php

namespace App\Filament\Widgets;

use App\Models\DebitTabungan;
use App\Models\KreditTabungan;
use App\Models\PemasukanKas;
use App\Models\PengeluaranKas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MyWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Debit', 'Rp ' . number_format(DebitTabungan::sum('nominal'), 0, ',', '.')),
            Stat::make('Total Kredit', 'Rp ' . number_format(KreditTabungan::sum('nominal'), 0, ',', '.')),
            Stat::make('Total Saldo Keseluruhan', function () {
                // Hitung total debit
                $totalDebit = DebitTabungan::sum('nominal');

                // Hitung total kredit
                $totalKredit = KreditTabungan::sum('nominal');

                // Hitung saldo keseluruhan
                $totalSaldo = $totalDebit - $totalKredit;

                return 'Rp ' . number_format($totalSaldo, 0, ',', '.');
            }),
            Stat::make('Total Pemasukan Kas', 'Rp ' . number_format(PemasukanKas::sum('nominal'), 0, ',', '.')),
            Stat::make('Total Pengeluaran Kas', 'Rp ' . number_format(PengeluaranKas::sum('nominal'), 0, ',', '.')),
            Stat::make('Total Saldo Keseluruhan', function () {
                // Hitung total debit
                $pemasukan = PemasukanKas::sum('nominal');

                // Hitung total kredit
                $pengeluaran = PengeluaranKas::sum('nominal');

                // Hitung saldo keseluruhan
                $totalSaldo = $pemasukan - $pengeluaran;

                return 'Rp ' . number_format($totalSaldo, 0, ',', '.');
            }),
        ];
    }
}
