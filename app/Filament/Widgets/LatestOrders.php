<?php

namespace App\Filament\Widgets;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Enums\Admin\OrderStatusEnum;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Son Siparişler';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Sipariş No')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Müşteri')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Tutar')
                    ->money('TRY')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (OrderStatusEnum $state): string => match ($state) {
                        OrderStatusEnum::PENDING => 'warning',
                        OrderStatusEnum::PROCESSING => 'info',
                        OrderStatusEnum::SHIPPED => 'primary',
                        OrderStatusEnum::DELIVERED => 'success',
                        OrderStatusEnum::CANCELLED => 'danger',
                    })
                    ->formatStateUsing(fn (OrderStatusEnum $state): string => $state->label()),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Ödeme')
                    ->badge()
                    ->color(fn (OrderPaymentStatusEnum $state): string => match ($state) {
                        OrderPaymentStatusEnum::PENDING => 'warning',
                        OrderPaymentStatusEnum::PAID => 'success',
                        OrderPaymentStatusEnum::FAILED => 'danger',
                        OrderPaymentStatusEnum::REFUNDED => 'gray',
                    })
                    ->formatStateUsing(fn (OrderPaymentStatusEnum $state): string => $state->label()),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Görüntüle')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.view', $record)),
            ])
            ->paginated(false);
    }
}
