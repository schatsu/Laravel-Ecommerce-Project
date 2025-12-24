<?php

namespace App\Filament\Resources;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Enums\Admin\OrderStatusEnum;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid as InfoGrid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'E-Ticaret';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Siparişler';
    protected static ?string $pluralModelLabel = 'Siparişler';
    protected static ?string $label = 'Sipariş';
    protected static ?string $slug = 'orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sipariş Durumu')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('Sipariş Durumu')
                                    ->options(collect(OrderStatusEnum::cases())->mapWithKeys(
                                        fn($case) => [$case->value => $case->label()]
                                    ))
                                    ->required(),
                                Select::make('payment_status')
                                    ->label('Ödeme Durumu')
                                    ->options(collect(OrderPaymentStatusEnum::cases())->mapWithKeys(
                                        fn($case) => [$case->value => $case->label()]
                                    ))
                                    ->required(),
                            ]),
                    ]),
                Section::make('Notlar')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Sipariş Notu')
                            ->rows(3)
                            ->placeholder('Siparişe not ekleyin...'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSection::make('Sipariş Bilgileri')
                    ->schema([
                        InfoGrid::make(3)
                            ->schema([
                                TextEntry::make('order_number')
                                    ->label('Sipariş No')
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('created_at')
                                    ->label('Tarih')
                                    ->dateTime('d.m.Y H:i'),
                                TextEntry::make('user.name')
                                    ->label('Müşteri'),
                            ]),
                        InfoGrid::make(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Sipariş Durumu')
                                    ->badge()
                                    ->color(fn($state) => $state->color()),
                                TextEntry::make('payment_status')
                                    ->label('Ödeme Durumu')
                                    ->badge()
                                    ->color(fn($state) => $state->color()),
                            ]),
                    ]),

                InfoSection::make('Ödeme Bilgileri')
                    ->schema([
                        InfoGrid::make(3)
                            ->schema([
                                TextEntry::make('subtotal')
                                    ->label('Ara Toplam')
                                    ->money('TRY'),
                                TextEntry::make('shipping_cost')
                                    ->label('Kargo')
                                    ->money('TRY'),
                                TextEntry::make('total')
                                    ->label('Toplam')
                                    ->money('TRY')
                                    ->weight('bold')
                                    ->size('lg'),
                            ]),
                        InfoGrid::make(2)
                            ->schema([
                                TextEntry::make('payment_method')
                                    ->label('Ödeme Yöntemi')
                                    ->formatStateUsing(fn($state) => match($state) {
                                        'credit_card' => 'Kredi Kartı',
                                        'iyzico' => 'iyzico',
                                        default => $state ?? 'Belirtilmemiş'
                                    }),
                                TextEntry::make('iyzico_payment_id')
                                    ->label('iyzico Ödeme ID')
                                    ->copyable()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->collapsible(),

                InfoSection::make('Sipariş Ürünleri')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                InfoGrid::make(4)
                                    ->schema([
                                        TextEntry::make('product.name')
                                            ->label('Ürün'),
                                        TextEntry::make('variation_info')
                                            ->label('Varyant')
                                            ->placeholder('-'),
                                        TextEntry::make('quantity')
                                            ->label('Adet'),
                                        TextEntry::make('total')
                                            ->label('Tutar')
                                            ->money('TRY'),
                                    ]),
                            ])
                            ->contained(false),
                    ]),

                InfoSection::make('Adres Bilgileri')
                    ->schema([
                        InfoGrid::make(2)
                            ->schema([
                                Group::make([
                                    TextEntry::make('billing_address.name')
                                        ->label('Fatura Adresi')
                                        ->weight('bold'),
                                    TextEntry::make('billing_full_address')
                                        ->label('')
                                        ->getStateUsing(function ($record) {
                                            $addr = $record->billing_address;
                                            if (!$addr) return '-';
                                            return ($addr['address'] ?? '') . ', ' .
                                                   ($addr['district'] ?? '') . ' / ' .
                                                   ($addr['city'] ?? '');
                                        }),
                                    TextEntry::make('billing_address.phone')
                                        ->label('Telefon')
                                        ->icon('heroicon-o-phone'),
                                ]),
                                Group::make([
                                    TextEntry::make('shipping_address.name')
                                        ->label('Teslimat Adresi')
                                        ->weight('bold'),
                                    TextEntry::make('shipping_full_address')
                                        ->label('')
                                        ->getStateUsing(function ($record) {
                                            $addr = $record->shipping_address;
                                            if (!$addr) return '-';
                                            return ($addr['address'] ?? '') . ', ' .
                                                   ($addr['district'] ?? '') . ' / ' .
                                                   ($addr['city'] ?? '');
                                        }),
                                    TextEntry::make('shipping_address.phone')
                                        ->label('Telefon')
                                        ->icon('heroicon-o-phone'),
                                ]),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Sipariş No')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('Müşteri')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Tutar')
                    ->money('TRY')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => $state->color()),
                TextColumn::make('payment_status')
                    ->label('Ödeme')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->label())
                    ->color(fn($state) => $state->color()),
                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Sipariş Durumu')
                    ->options(collect(OrderStatusEnum::cases())->mapWithKeys(
                        fn($case) => [$case->value => $case->label()]
                    )),
                SelectFilter::make('payment_status')
                    ->label('Ödeme Durumu')
                    ->options(collect(OrderPaymentStatusEnum::cases())->mapWithKeys(
                        fn($case) => [$case->value => $case->label()]
                    )),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', OrderStatusEnum::PENDING)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Bekleyen sipariş sayısı';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'items.product']);
    }
}
