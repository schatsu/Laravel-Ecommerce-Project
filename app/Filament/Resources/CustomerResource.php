<?php

namespace App\Filament\Resources;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Enums\Admin\OrderStatusEnum;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Coupon;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid as InfoGrid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'E-Ticaret';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Müşteriler';
    protected static ?string $pluralModelLabel = 'Müşteriler';
    protected static ?string $label = 'Müşteri';
    protected static ?string $slug = 'customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kişisel Bilgiler')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Ad')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('surname')
                                    ->label('Soyad')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label('E-posta')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Telefon')
                                    ->tel()
                                    ->maxLength(20),
                            ]),
                    ]),
                Section::make('Hesap Ayarları')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('password')
                                    ->label('Şifre')
                                    ->password()
                                    ->revealable()
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->maxLength(255)
                                    ->helperText('Düzenlerken boş bırakırsanız mevcut şifre korunur'),
                                DateTimePicker::make('email_verified_at')
                                    ->label('E-posta Doğrulama Tarihi')
                                    ->nullable(),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSection::make('Müşteri Bilgileri')
                    ->schema([
                        InfoGrid::make(3)
                            ->schema([
                                TextEntry::make('full_name')
                                    ->label('Ad Soyad')
                                    ->weight('bold'),
                                TextEntry::make('email')
                                    ->label('E-posta')
                                    ->copyable(),
                                TextEntry::make('phone')
                                    ->label('Telefon')
                                    ->placeholder('-'),
                            ]),
                        InfoGrid::make(3)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Kayıt Tarihi')
                                    ->dateTime('d.m.Y H:i'),
                                TextEntry::make('email_verified_at')
                                    ->label('E-posta Doğrulama')
                                    ->dateTime('d.m.Y H:i')
                                    ->placeholder('Doğrulanmadı')
                                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                                TextEntry::make('orders_count')
                                    ->label('Toplam Sipariş')
                                    ->getStateUsing(fn ($record) => $record->orders()->count())
                                    ->badge()
                                    ->color('primary'),
                            ]),
                    ]),

                InfoSection::make('Sipariş Geçmişi')
                    ->schema([
                        RepeatableEntry::make('orders')
                            ->label('')
                            ->schema([
                                InfoGrid::make(5)
                                    ->schema([
                                        TextEntry::make('order_number')
                                            ->label('Sipariş No')
                                            ->weight('bold'),
                                        TextEntry::make('total')
                                            ->label('Tutar')
                                            ->money('TRY'),
                                        TextEntry::make('status')
                                            ->label('Durum')
                                            ->badge()
                                            ->formatStateUsing(fn ($state) => $state->label())
                                            ->color(fn ($state) => $state->color()),
                                        TextEntry::make('payment_status')
                                            ->label('Ödeme')
                                            ->badge()
                                            ->formatStateUsing(fn ($state) => $state->label())
                                            ->color(fn ($state) => $state->color()),
                                        TextEntry::make('created_at')
                                            ->label('Tarih')
                                            ->dateTime('d.m.Y'),
                                    ]),
                            ])
                            ->contained(false),
                    ])
                    ->collapsed()
                    ->collapsible(),

                InfoSection::make('Sepet İçeriği')
                    ->schema([
                        TextEntry::make('cart_info')
                            ->label('')
                            ->getStateUsing(function ($record) {
                                $cart = $record->cart;
                                if (!$cart || $cart->items->isEmpty()) {
                                    return 'Sepet boş';
                                }
                                
                                $items = $cart->items->map(function ($item) {
                                    $name = $item->product->name ?? 'Ürün';
                                    $qty = $item->quantity;
                                    $total = number_format($item->total, 2, ',', '.') . ' ₺';
                                    return "• {$name} x{$qty} = {$total}";
                                })->join("\n");
                                
                                $subtotal = number_format($cart->subtotal, 2, ',', '.') . ' ₺';
                                return $items . "\n\n**Toplam: {$subtotal}**";
                            })
                            ->markdown(),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Ad Soyad')
                    ->searchable(['name', 'surname'])
                    ->sortable(['name']),
                TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('orders_count')
                    ->label('Sipariş')
                    ->counts('orders')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('orders_sum_total')
                    ->label('Toplam Harcama')
                    ->sum('orders', 'total')
                    ->money('TRY'),
                TextColumn::make('created_at')
                    ->label('Kayıt')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label('E-posta Doğrulanmış')
                    ->query(fn (Builder $query) => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('has_orders')
                    ->label('Sipariş Vermiş')
                    ->query(fn (Builder $query) => $query->has('orders')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('assign_coupon')
                    ->label('Kupon Ata')
                    ->icon('heroicon-o-ticket')
                    ->color('success')
                    ->form([
                        Select::make('coupon_id')
                            ->label('Kupon')
                            ->options(Coupon::query()->active()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Müşterinin sepetine kupon atanacak'),
                    ])
                    ->action(function ($record, array $data) {
                        $cart = $record->cart;
                        if (!$cart) {
                            $cart = $record->cart()->create([]);
                        }
                        $cart->update(['coupon_id' => $data['coupon_id']]);
                    })
                    ->successNotificationTitle('Kupon müşterinin sepetine atandı'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrdersRelationManager::class,
            \App\Filament\Resources\InvoiceRelationManagerResource\RelationManagers\InvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'super_admin');
            })
            ->with(['orders', 'cart.items.product']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }
}
