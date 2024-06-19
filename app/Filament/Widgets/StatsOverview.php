<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;


class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {


        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();
            

      $pemasukan= Transaction::incomes()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');

      $pengeluaran= Transaction::expenses()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');

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
