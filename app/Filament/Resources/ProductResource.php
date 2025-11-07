<?php

namespace App\Filament\Resources;

use App\Enums\Admin\ProductStatusEnum;
use App\Enums\ProductVariationType;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'E-Ticaret';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Ürünler';
    protected static ?string $pluralModelLabel = 'Ürünler';
    protected static ?string $label = 'Ürün';

    protected static ?string $slug = 'products';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Genel Bilgiler')
                        ->schema([
                            Grid::make()
                                ->schema([
                                    Select::make('category_id')
                                        ->relationship('category', 'name')
                                        ->label('Kategori')
                                        ->searchable()
                                        ->preload(),
                                    TextInput::make('name')
                                        ->label('Ad')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                            $set("slug", Str::slug($state));
                                        }),
                                    TextInput::make('slug')
                                        ->label('Slug')
                                        ->required(),
                                    TextInput::make('cost_price')
                                        ->label('Ürün Maliyeti')
                                        ->numeric()
                                        ->nullable()
                                        ->prefix('₺'),
                                    TextInput::make('selling_price')
                                        ->label('Satış Fiyatı')
                                        ->numeric()
                                        ->required()
                                        ->prefix('₺'),
                                    TextInput::make('discount_price')
                                        ->label('İndirimli Satış Fiyatı')
                                        ->numeric()
                                        ->nullable()
                                        ->prefix('₺'),
                                    Textarea::make('short_description')
                                        ->label('Kısa Açıklama')
                                        ->required()
                                        ->rows(2)
                                        ->maxLength(255)
                                        ->columnSpanFull(),
                                    RichEditor::make('description')
                                        ->label('Ürün Açıklaması')
                                        ->required()
                                        ->toolbarButtons([
                                            'blockquote', 'bold', 'bulletList', 'h2', 'h3', 'italic', 'underline',
                                            'orderedList', 'redo', 'strike', 'undo', 'table',
                                        ])
                                        ->columnSpanFull(),
                                    Select::make('status')
                                        ->label('Durum')
                                        ->options(ProductStatusEnum::labels())
                                        ->default(ProductStatusEnum::PUBLISHED->value)
                                        ->columnSpanFull(),
                                ])
                        ]),
                    Step::make('Ürün Ayarları')
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    Toggle::make('is_featured')->label('Öne Çıkar')->nullable(),
                                    Toggle::make('is_new')->label('Yeni Ürün')->nullable(),
                                    Toggle::make('is_best_seller')->label('Çok Satan')->nullable(),
                                ])
                        ]),
                    Step::make('SEO')
                        ->schema([
                            TextInput::make('meta_title')
                                ->label('SEO Başlık')
                                ->nullable()
                                ->maxLength(100),
                            TextInput::make('meta_description')
                                ->label('SEO Açıklama')
                                ->nullable()
                                ->maxLength(255),
                            TextInput::make('meta_keywords')
                                ->label('SEO Anahtar Kelimeler')
                                ->nullable()
                                ->helperText('SEO Anahtar Kelimeleri virgül ile ayırarak giriniz'),
                        ]),
                ])->skippable()
                  ->columnSpanFull()
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->limit(1)
                    ->conversion('thumb')
                    ->circular()
                    ->label('Ürün Görseli'),
                TextColumn::make('name')
                    ->words(10)
                    ->label('Ad')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('cost_price')
                    ->label('Maliyet')
                    ->money('TRY')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('selling_price')
                    ->label('Satış Fiyatı')
                    ->money('TRY')
                    ->sortable(),

                TextColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn($state) => $state ? 'Evet' : 'Hayır'),

                TextColumn::make('is_new')
                    ->label('Yeni Ürün')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn($state) => $state ? 'Evet' : 'Hayır'),

                TextColumn::make('is_best_seller')
                    ->label('Çok Satan')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->formatStateUsing(fn($state) => $state ? 'Evet' : 'Hayır'),

                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->colors(ProductStatusEnum::colors())
                    ->formatStateUsing(fn($state) => ProductStatusEnum::labels()[$state->value] ?? $state->value),

                TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Durum')
                    ->options(ProductStatusEnum::labels()),
                SelectFilter::make('is_featured')
                    ->label('Öne Çıkar')
                    ->options([
                        '1' => 'Evet',
                        '0' => 'Hayır',
                    ]),
                SelectFilter::make('is_new')
                    ->label('Yeni Ürün')
                    ->options([
                        '1' => 'Evet',
                        '0' => 'Hayır',
                    ]),
                SelectFilter::make('is_best_seller')
                    ->label('Çok Satan')
                    ->options([
                        '1' => 'Evet',
                        '0' => 'Hayır',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'images' => Pages\ProductImages::route('/{record}/images'),
            'product-options' => Pages\ProductVariationTypes::route('/{record}/product-options'),
            'product-variations' => Pages\ProductVariations::route('/{record}/product-variations'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditProduct::class,
            Pages\ProductImages::class,
            Pages\ProductVariationTypes::class,
            Pages\ProductVariations::class
        ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Ürün sayısı';
    }
}
