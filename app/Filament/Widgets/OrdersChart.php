<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Sipariş Grafiği';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'date' => $date->format('D'),
                'orders' => Order::whereDate('created_at', $date)->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Sipariş',
                    'data' => $data->pluck('orders')->toArray(),
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
