<?php

namespace App\Filament\Widgets;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AverageOrderStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Ortalama sipariş tutarı (bu ay)
        $thisMonthOrders = Order::where('created_at', '>=', $thisMonth)
            ->where('payment_status', OrderPaymentStatusEnum::PAID);
        $thisMonthAvg = $thisMonthOrders->count() > 0
            ? $thisMonthOrders->sum('total') / $thisMonthOrders->count()
            : 0;

        // Ortalama sipariş tutarı (geçen ay)
        $lastMonthOrders = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->where('payment_status', OrderPaymentStatusEnum::PAID);
        $lastMonthAvg = $lastMonthOrders->count() > 0
            ? $lastMonthOrders->sum('total') / $lastMonthOrders->count()
            : 0;

        // Değişim yüzdesi
        $avgChange = $lastMonthAvg > 0
            ? round((($thisMonthAvg - $lastMonthAvg) / $lastMonthAvg) * 100, 1)
            : 0;

        // Toplam sipariş sayısı
        $totalOrders = Order::count();
        $paidOrders = Order::where('payment_status', OrderPaymentStatusEnum::PAID)->count();

        // Dönüşüm oranı (ödenen/toplam)
        $conversionRate = $totalOrders > 0
            ? round(($paidOrders / $totalOrders) * 100, 1)
            : 0;

        // Genel ortalama sipariş tutarı
        $overallAvg = $paidOrders > 0
            ? Order::where('payment_status', OrderPaymentStatusEnum::PAID)->sum('total') / $paidOrders
            : 0;

        return [
            Stat::make('Ortalama Sipariş', number_format($overallAvg, 2, ',', '.') . ' ₺')
                ->description('Genel ortalama tutar')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info'),

            Stat::make('Aylık Ortalama', number_format($thisMonthAvg, 2, ',', '.') . ' ₺')
                ->description($avgChange >= 0 ? "%{$avgChange} artış" : "%{$avgChange} düşüş")
                ->descriptionIcon($avgChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($avgChange >= 0 ? 'success' : 'danger'),

            Stat::make('Dönüşüm Oranı', '%' . $conversionRate)
                ->description("{$paidOrders}/{$totalOrders} başarılı")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($conversionRate >= 50 ? 'success' : 'warning'),
        ];
    }
}
