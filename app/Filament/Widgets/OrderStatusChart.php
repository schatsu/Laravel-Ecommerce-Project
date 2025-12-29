<?php

namespace App\Filament\Widgets;

use App\Enums\Admin\OrderStatusEnum;
use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Sipariş Durumları';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $statuses = [
            OrderStatusEnum::PENDING->value => ['label' => 'Beklemede', 'color' => 'rgba(245, 158, 11, 0.8)'],
            OrderStatusEnum::PROCESSING->value => ['label' => 'İşleniyor', 'color' => 'rgba(59, 130, 246, 0.8)'],
            OrderStatusEnum::SHIPPED->value => ['label' => 'Kargoda', 'color' => 'rgba(139, 92, 246, 0.8)'],
            OrderStatusEnum::DELIVERED->value => ['label' => 'Teslim Edildi', 'color' => 'rgba(16, 185, 129, 0.8)'],
            OrderStatusEnum::CANCELLED->value => ['label' => 'İptal', 'color' => 'rgba(239, 68, 68, 0.8)'],
        ];

        $data = [];
        $labels = [];
        $colors = [];

        foreach ($statuses as $status => $info) {
            $count = Order::where('status', $status)->count();
            if ($count > 0) {
                $data[] = $count;
                $labels[] = $info['label'];
                $colors[] = $info['color'];
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
