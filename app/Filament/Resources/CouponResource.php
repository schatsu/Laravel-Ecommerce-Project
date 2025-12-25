<?php

namespace App\Filament\Resources;

use App\Enums\CouponType;
use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Exception;
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
use Filament\Forms\Set;
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
                Grid::make(3)
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Section::make('Kupon Bilgileri')
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Kupon Kodu')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(50)
                                            ->placeholder('INDIRIM20')
                                            ->suffixAction(
                                                Action::make('generate')
                                                    ->icon('heroicon-o-arrow-path')
                                                    ->tooltip('Rastgele Kod Üret')
                                                    ->action(fn ($set) => $set('code', strtoupper(Str::random(8))))
                                            ),
                                        TextInput::make('name')
                                            ->label('Kupon Adı')
                                            ->required()
                                            ->maxLength(100)
                                            ->placeholder('Yılbaşı İndirimi'),
                                        Textarea::make('description')
                                            ->label('Açıklama')
                                            ->rows(2)
                                            ->placeholder('Kupon hakkında açıklama...')
                                            ->columnSpanFull(),
                                    ])->collapsible(),

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
                                                    ->suffix(fn (Get $get) => $get('type') === 'percentage' ? '%' : '₺'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('min_order_amount')
                                                    ->label('Min. Sepet Tutarı')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->prefix('₺')
                                                    ->placeholder('Yok'),
                                                TextInput::make('max_discount_amount')
                                                    ->label('Maks. İndirim')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->prefix('₺')
                                                    ->placeholder('Yok'),
                                            ]),
                                    ])->collapsible(),
                            ])
                            ->columnSpan(2),

                        Grid::make(1)
                            ->schema([
                                Section::make('Durum')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Aktif')
                                            ->default(true)
                                            ->onIcon('heroicon-o-check')
                                            ->offIcon('heroicon-o-x-mark')
                                            ->onColor('success'),
                                    ])->collapsible(),

                                Section::make('Kullanım Limitleri')
                                    ->schema([
                                        TextInput::make('usage_limit')
                                            ->label('Toplam Limit')
                                            ->numeric()
                                            ->nullable()
                                            ->placeholder('Sınırsız'),
                                        TextInput::make('usage_limit_per_user')
                                            ->label('Kullanıcı Başına')
                                            ->numeric()
                                            ->nullable()
                                            ->placeholder('Sınırsız'),
                                    ])
                                    ->collapsible(),

                                Section::make('Geçerlilik Süresi')
                                    ->schema([
                                        Grid::make(1)->schema([
                                            DateTimePicker::make('starts_at')
                                                ->label('Başlangıç Tarihi')
                                                ->native(false)
                                                ->displayFormat('d/m/Y H:i')
                                                ->seconds(false)
                                                ->placeholder('Şimdi (Boş bırakılırsa hemen başlar)')
                                                ->live()
                                                ->afterStateUpdated(fn ($state, Set $set, Get $get) =>
                                                $get('expires_at') < $state ? $set('expires_at', null) : null
                                                ),

                                            DateTimePicker::make('expires_at')
                                                ->label('Bitiş Tarihi')
                                                ->native(false)
                                                ->displayFormat('d/m/Y H:i')
                                                ->seconds(false)
                                                ->placeholder('Süresiz (Boş bırakılırsa hiç bitmez)')
                                                ->afterOrEqual('starts_at')
                                                ->validationMessages([
                                                    'after_or_equal' => 'Bitiş tarihi, başlangıç tarihinden önce olamaz.',
                                                ]),
                                        ]),
                                    ])
                                    ->collapsible(),
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
                TextColumn::make('code')
                    ->label('Kupon Kodu')
                    ->searchable(['code', 'name'])
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),
                TextColumn::make('name')
                    ->label('Kupon Adı'),
                TextColumn::make('formatted_value')
                    ->label('İndirim')
                    ->badge()
                    ->color('success'),
                TextColumn::make('usage_count')
                    ->label('Kullanım')
                    ->getStateUsing(fn ($record) => $record->usage_limit
                        ? "{$record->used_count}/{$record->usage_limit}"
                        : $record->used_count)
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),
                TextColumn::make('expires_at')
                    ->label('Bitiş')
                    ->date('d.m.Y')
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
        return static::getEloquentQuery()->count() ?: null;
    }

}
