<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Resources\InvoiceRelationManagerResource\RelationManagers\InvoicesRelationManager;
use App\Models\Coupon;
use App\Models\User;
use Exception;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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
                Grid::make(3)
                    ->schema([
                        Section::make('Kişisel Bilgiler')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Ad')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('surname')
                                    ->label('Soyad')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('E-posta')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Telefon')
                                    ->tel()
                                    ->mask('(999) 999 99 99')
                                    ->maxLength(20),
                            ])
                            ->columnSpan(2),

                        Grid::make(1)
                            ->schema([
                                Section::make('Hesap')
                                    ->icon('heroicon-o-lock-closed')
                                    ->schema([
                                        TextInput::make('password')
                                            ->label('Şifre')
                                            ->password()
                                            ->revealable()
                                            ->required(fn(string $context): bool => $context === 'create')
                                            ->dehydrated(fn($state) => filled($state))
                                            ->maxLength(255)
                                            ->helperText(fn(string $context) => $context === 'edit'
                                                ? 'Boş bırakırsanız mevcut şifre korunur'
                                                : null),
                                        DateTimePicker::make('email_verified_at')
                                            ->label('E-posta Doğrulama')
                                            ->native(false)
                                            ->displayFormat('d.m.Y H:i')
                                            ->format('Y-m-d H:i:s')
                                            ->nullable(),
                                    ]),

                                Section::make('Kupon Ata')
                                    ->icon('heroicon-o-ticket')
                                    ->schema([
                                        Select::make('cart_coupon_id')
                                            ->label('Sepete Kupon Ekle')
                                            ->options(Coupon::query()->active()->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->placeholder('Kupon seçin...')
                                            ->helperText('Müşterinin sepetine otomatik uygulanır')
                                            ->dehydrated(false)
                                            ->afterStateHydrated(function ($component, $record) {
                                                if ($record && $record->cart) {
                                                    $component->state($record->cart->coupon_id);
                                                }
                                            }),
                                        Placeholder::make('coupon_note')
                                            ->label('')
                                            ->content('Kupon, müşteri sepetini görüntülediğinde aktif olacaktır.')
                                            ->visible(fn(string $context) => $context === 'create'),
                                    ])
                                    ->collapsible()
                                    ->collapsed(fn(string $context) => $context === 'create'),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Müşteri')
                    ->searchable(['name', 'surname']),
                TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('orders_count')
                    ->label('Sipariş')
                    ->counts('orders')
                    ->badge()
                    ->tooltip('Toplam Şipariş')
                    ->sortable()
                    ->color('primary')
                    ->alignCenter(),
                TextColumn::make('orders_sum_total')
                    ->label('Harcama')
                    ->tooltip('Toplam Harcama')
                    ->sum('orders', 'total')
                    ->money('TRY')
                    ->sortable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('E-Posta Doğrulaması')
                    ->boolean()
                    ->alignCenter()
                    ->getStateUsing(fn ($record) => ! is_null($record->email_verified_at))
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Kayıt')
                    ->dateTime('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label('E-posta Doğrulanmış')
                    ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('has_orders')
                    ->label('Sipariş Vermiş')
                    ->query(fn(Builder $query) => $query->has('orders')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
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
            InvoicesRelationManager::class,
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
            });
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count() ?: null;
    }

}
