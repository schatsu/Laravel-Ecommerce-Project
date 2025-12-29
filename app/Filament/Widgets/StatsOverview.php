<?php

namespace App\Filament\Widgets;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Enums\Admin\OrderStatusEnum;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Bugünkü siparişler
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('payment_status', OrderPaymentStatusEnum::PAID)
            ->sum('total');

        // Bu ayki gelir
        $thisMonthRevenue = Order::where('created_at', '>=', $thisMonth)
            ->where('payment_status', OrderPaymentStatusEnum::PAID)
            ->sum('total');

        // Geçen ayki gelir (karşılaştırma için)
        $lastMonthRevenue = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->where('payment_status', OrderPaymentStatusEnum::PAID)
            ->sum('total');

        // Gelir değişimi yüzdesi
        $revenueChange = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 100;

        // Bekleyen siparişler
        $pendingOrders = Order::where('status', OrderStatusEnum::PENDING)->count();

        // Toplam müşteri
        $totalCustomers = User::whereDoesntHave('roles')->count();

        // Son 7 günün sipariş trendi
        $last7Days = collect(range(6, 0))->map(function ($daysAgo) {
            return Order::whereDate('created_at', Carbon::today()->subDays($daysAgo))->count();
        })->toArray();

        return [
            Stat::make('Bugünkü Sipariş', $todayOrders)
                ->description('Bugün alınan siparişler')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->chart($last7Days)
                ->color('success'),

            Stat::make('Bugünkü Gelir', number_format($todayRevenue, 2, ',', '.') . ' ₺')
                ->description('Bugünkü ödenen siparişler')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Aylık Gelir', number_format($thisMonthRevenue, 2, ',', '.') . ' ₺')
                ->description($revenueChange >= 0 ? "%{$revenueChange} artış" : "%{$revenueChange} düşüş")
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger'),

            Stat::make('Bekleyen Siparişler', $pendingOrders)
                ->description('İşlem bekleyen')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 10 ? 'warning' : 'info'),

            Stat::make('Toplam Müşteri', number_format($totalCustomers))
                ->description('Kayıtlı müşteriler')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
