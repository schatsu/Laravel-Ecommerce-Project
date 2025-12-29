<?php

namespace App\Filament\Widgets;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Gelir Grafiği';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Son 7 Gün',
            '30' => 'Son 30 Gün',
            '90' => 'Son 3 Ay',
            '365' => 'Son 1 Yıl',
        ];
    }

    protected function getData(): array
    {
        $days = (int) $this->filter;

        $data = collect(range($days - 1, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            $revenue = Order::whereDate('created_at', $date)
                ->where('payment_status', OrderPaymentStatusEnum::PAID)
                ->sum('total');

            return [
                'date' => $date->format('d M'),
                'revenue' => round($revenue, 2),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Gelir (₺)',
                    'data' => $data->pluck('revenue')->toArray(),
                    'fill' => true,
                    'backgroundColor' => 'rgba(249, 115, 22, 0.1)',
                    'borderColor' => 'rgb(249, 115, 22)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
