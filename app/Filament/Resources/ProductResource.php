<?php

namespace App\Filament\Resources;

use App\Enums\Admin\ProductStatusEnum;
use App\Enums\ProductVariationType;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Exception;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Ürün')
                    ->tabs([
                        Tab::make('Genel Bilgiler')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Ürün Adı')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                                $set("slug", Str::slug($state));
                                            }),
                                        TextInput::make('slug')
                                            ->label('URL (Slug)')
                                            ->required(),
                                        Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->label('Kategori')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('status')
                                            ->label('Durum')
                                            ->options(ProductStatusEnum::labels())
                                            ->default(ProductStatusEnum::PUBLISHED->value)
                                            ->required(),
                                    ]),
                                Textarea::make('short_description')
                                    ->label('Kısa Açıklama')
                                    ->required()
                                    ->rows(2)
                                    ->maxLength(255),
                                RichEditor::make('description')
                                    ->label('Ürün Açıklaması')
                                    ->required()
                                    ->toolbarButtons([
                                        'blockquote', 'bold', 'bulletList', 'h2', 'h3', 'italic', 'underline',
                                        'orderedList', 'redo', 'strike', 'undo', 'table',
                                    ]),
                                Section::make('Ürün Görselleri')
                                    ->description('Ana ürün görsellerini buraya yükleyin')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('images')
                                            ->label('')
                                            ->image()
                                            ->multiple()
                                            ->openable()
                                            ->panelLayout('grid')
                                            ->collection('images')
                                            ->reorderable()
                                            ->appendFiles()
                                            ->preserveFilenames()
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Fiyat & Stok')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Section::make('Fiyatlandırma')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('cost_price')
                                                    ->label('Maliyet Fiyatı')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->prefix('₺'),
                                                TextInput::make('selling_price')
                                                    ->label('Satış Fiyatı')
                                                    ->numeric()
                                                    ->required()
                                                    ->prefix('₺'),
                                                TextInput::make('discount_price')
                                                    ->label('İndirimli Fiyat')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->prefix('₺')
                                                    ->helperText('Boş bırakırsanız indirim uygulanmaz'),
                                            ]),
                                    ]),
                                Section::make('Ürün Ayarları')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_featured')
                                                    ->label('Öne Çıkar')
                                                    ->helperText('Anasayfada göster'),
                                                Toggle::make('is_new')
                                                    ->label('Yeni Ürün')
                                                    ->helperText('"Yeni" etiketi ekle'),
                                                Toggle::make('is_best_seller')
                                                    ->label('Çok Satan')
                                                    ->helperText('"Çok Satan" etiketi ekle'),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('Varyantlar')
                            ->icon('heroicon-o-squares-plus')
                            ->schema([
                                Section::make('Varyant Özellikleri')
                                    ->description('Renk, beden, kapasite gibi varyant tiplerini tanımlayın')
                                    ->schema([
                                        Repeater::make('variationTypes')
                                            ->label('')
                                            ->relationship()
                                            ->collapsible()
                                            ->collapsed()
                                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Yeni Özellik')
                                            ->addActionLabel('Özellik Ekle')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->label('Özellik Adı')
                                                            ->placeholder('Örn: Renk, Kapasite, Beden')
                                                            ->required()
                                                            ->maxLength(255),
                                                        Select::make('type')
                                                            ->label('Görünüm Tipi')
                                                            ->options(ProductVariationType::labels())
                                                            ->default(ProductVariationType::SELECT->value)
                                                            ->helperText('IMAGE: Görsel ile seçim, SELECT: Dropdown, RADIO: Butonlar'),
                                                    ]),
                                                Repeater::make('options')
                                                    ->label('Seçenekler')
                                                    ->relationship()
                                                    ->collapsible()
                                                    ->collapsed()
                                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Yeni Seçenek')
                                                    ->addActionLabel('Seçenek Ekle')
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                TextInput::make('name')
                                                                    ->label('Seçenek Adı')
                                                                    ->placeholder('Örn: Mavi, 256GB, XL')
                                                                    ->required(),
                                                                SpatieMediaLibraryFileUpload::make('images')
                                                                    ->label('Seçenek Görseli')
                                                                    ->helperText('Sadece IMAGE tipinde kullanılır')
                                                                    ->image()
                                                                    ->multiple()
                                                                    ->openable()
                                                                    ->panelLayout('grid')
                                                                    ->collection('images')
                                                                    ->reorderable()
                                                                    ->appendFiles()
                                                                    ->preserveFilenames(),
                                                            ]),
                                                    ]),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('Arama Motoru Optimizasyonu')
                                    ->description('Google ve diğer arama motorları için meta bilgileri')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('SEO Başlık')
                                            ->nullable()
                                            ->maxLength(100)
                                            ->helperText('Boş bırakırsanız ürün adı kullanılır'),
                                        Textarea::make('meta_description')
                                            ->label('SEO Açıklama')
                                            ->nullable()
                                            ->maxLength(255)
                                            ->rows(3)
                                            ->helperText('Arama sonuçlarında görünecek açıklama'),
                                        TextInput::make('meta_keywords')
                                            ->label('Anahtar Kelimeler')
                                            ->nullable()
                                            ->helperText('Virgül ile ayırarak yazın'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
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
                    ->label('Görsel'),
                TextColumn::make('name')
                    ->words(8)
                    ->label('Ürün Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('selling_price')
                    ->label('Fiyat')
                    ->money('TRY')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->colors(ProductStatusEnum::colors())
                    ->formatStateUsing(fn($state) => ProductStatusEnum::labels()[$state->value] ?? $state->value),
                TextColumn::make('variations_count')
                    ->counts('variations')
                    ->label('Varyant')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Durum')
                    ->options(ProductStatusEnum::labels()),
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('is_featured')
                    ->label('Öne Çıkan')
                    ->options([
                        '1' => 'Evet',
                        '0' => 'Hayır',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'product-variations' => Pages\ProductVariations::route('/{record}/product-variations'),
        ];
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
