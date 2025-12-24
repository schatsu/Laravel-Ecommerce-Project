<?php

namespace App\Filament\Resources;

use App\Enums\CouponType;
use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationGroup = 'E-Ticaret';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Kuponlar';
    protected static ?string $pluralModelLabel = 'Kuponlar';
    protected static ?string $label = 'Kupon';
    protected static ?string $slug = 'coupons';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kupon Bilgileri')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->label('Kupon Kodu')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->placeholder('INDIRIM20')
                                    ->helperText('Benzersiz kupon kodu')
                                    ->suffixAction(
                                        Action::make('generate')
                                            ->icon('heroicon-o-arrow-path')
                                            ->action(fn ($set) => $set('code', strtoupper(Str::random(8))))
                                    ),
                                TextInput::make('name')
                                    ->label('Kupon Adı')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('Yılbaşı İndirimi'),
                            ]),
                        Textarea::make('description')
                            ->label('Açıklama')
                            ->rows(2)
                            ->placeholder('Kupon hakkında açıklama...'),
                    ]),

                Section::make('İndirim Ayarları')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('type')
                                    ->label('İndirim Tipi')
                                    ->options(CouponType::labels())
                                    ->default(CouponType::PERCENTAGE->value)
                                    ->required()
                                    ->live(),
                                TextInput::make('value')
                                    ->label('İndirim Değeri')
                                    ->numeric()
                                    ->required()
                                    ->suffix(fn (Get $get) => $get('type') === 'percentage' ? '%' : '₺')
                                    ->helperText(fn (Get $get) => $get('type') === 'percentage'
                                        ? 'Yüzde olarak indirim (örn: 20)'
                                        : 'Sabit tutar indirim (örn: 50)'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('min_order_amount')
                                    ->label('Minimum Sepet Tutarı')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('₺')
                                    ->helperText('Bu tutarın altındaki siparişlerde geçersiz'),
                                TextInput::make('max_discount_amount')
                                    ->label('Maksimum İndirim Tutarı')
                                    ->numeric()
                                    ->nullable()
                                    ->prefix('₺')
                                    ->helperText('İndirim bu tutarı aşamaz'),
                            ]),
                    ]),

                Section::make('Kullanım Limitleri')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('usage_limit')
                                    ->label('Toplam Kullanım Limiti')
                                    ->numeric()
                                    ->nullable()
                                    ->placeholder('Sınırsız')
                                    ->helperText('Boş bırakırsanız sınırsız kullanılabilir'),
                                TextInput::make('usage_limit_per_user')
                                    ->label('Kullanıcı Başına Limit')
                                    ->numeric()
                                    ->nullable()
                                    ->placeholder('Sınırsız')
                                    ->helperText('Her kullanıcı kaç kez kullanabilir'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Geçerlilik Süresi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('starts_at')
                                    ->label('Başlangıç Tarihi')
                                    ->nullable()
                                    ->placeholder('Hemen'),
                                DateTimePicker::make('expires_at')
                                    ->label('Bitiş Tarihi')
                                    ->nullable()
                                    ->placeholder('Süresiz'),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('Durum')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Kuponu aktif/pasif yapın'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kod')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->copyable()
                    ->color('primary'),
                TextColumn::make('name')
                    ->label('Ad')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('formatted_value')
                    ->label('İndirim')
                    ->badge()
                    ->color('success'),
                TextColumn::make('min_order_amount')
                    ->label('Min. Tutar')
                    ->money('TRY')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('usage_count')
                    ->label('Kullanım')
                    ->getStateUsing(fn ($record) => $record->usage_limit
                        ? "{$record->used_count} / {$record->usage_limit}"
                        : $record->used_count)
                    ->badge()
                    ->color('gray'),
                TextColumn::make('expires_at')
                    ->label('Bitiş')
                    ->dateTime('d.m.Y')
                    ->placeholder('Süresiz')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn ($record) => $record->status_color),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Tip')
                    ->options(CouponType::labels()),
                SelectFilter::make('is_active')
                    ->label('Durum')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Pasif',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Aktif kupon sayısı';
    }
}
