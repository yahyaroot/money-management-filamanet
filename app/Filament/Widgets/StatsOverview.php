<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
      $pemasukan= Transaction::incomes()->get()->sum('amount');

      $pengeluaran= Transaction::expenses()->get()->sum('amount');

        return [
            Card::make('Pemasukan', $pemasukan)
            ->description('Chart')
            ->descriptionIcon('heroicon-o-arrow-down'),
            Card::make('Pengeluaran', $pengeluaran)
            ->description('Chart')
            ->descriptionIcon('heroicon-o-arrow-up'),
            Card::make('Sisa', $pemasukan-$pengeluaran),
         
        ];
    }
}
