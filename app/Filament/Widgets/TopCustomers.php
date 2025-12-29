<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopCustomers extends BaseWidget
{
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 1;
    protected static ?string $heading = 'En İyi Müşteriler';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->whereDoesntHave('roles')
                    ->whereHas('orders')
                    ->withCount('orders')
                    ->withSum('orders', 'total')
                    ->orderByDesc('orders_sum_total')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Müşteri')
                    ->searchable()
                    ->description(fn ($record) => $record->email),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label('Sipariş')
                    ->suffix(' adet')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('orders_sum_total')
                    ->label('Toplam Harcama')
                    ->money('TRY')
                    ->weight('bold'),
            ])
            ->paginated(false);
    }
}
