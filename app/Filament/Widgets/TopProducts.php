<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopProducts extends BaseWidget
{
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 1;
    protected static ?string $heading = 'En Çok Satan Ürünler';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereHas('orderItems')
                    ->withSum('orderItems', 'quantity')
                    ->withSum('orderItems', 'total')
                    ->orderByDesc('order_items_sum_quantity')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('images'))
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Ürün')
                    ->limit(30),

                Tables\Columns\TextColumn::make('order_items_sum_quantity')
                    ->label('Satış')
                    ->suffix(' adet')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('order_items_sum_total')
                    ->label('Gelir')
                    ->money('TRY'),
            ])
            ->paginated(false);
    }
}
