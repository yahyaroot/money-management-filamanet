<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Transaction;

class WidgetIncomeChart extends ChartWidget
{

    protected static ?string $heading = 'Pemasukkan';

    protected static string $color="success";

    protected function getData(): array
    {
        $expensesQuery = Transaction::incomes();

        $data = Trend::query($expensesQuery)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perDay()
        ->sum('amount');
 
    return [
        'datasets' => [
            [
                'label' => 'Pemasukkan',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }

}
