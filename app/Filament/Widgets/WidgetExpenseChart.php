<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WidgetExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Pengeluaran';

    protected static string $color="danger";

    protected function getData(): array
    {
        $expensesQuery = Transaction::expenses();

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
                'label' => 'Pengeluaran',
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
