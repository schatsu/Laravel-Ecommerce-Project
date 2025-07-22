<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\VariantOption;
use App\Models\VariantValue;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Wizard::make([
                    Step::make('Ürün Detayları')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Ürün Adı')
                                        ->required()
                                        ->maxLength(255),

                                    Select::make('category_id')
                                        ->label('Kategori')
                                        ->options(Category::query()->pluck('name', 'id'))
                                        ->searchable()
                                        ->required(),
                                ]),
                            Textarea::make('short_description')
                                ->label('Kısa Açıklama')
                                ->required()
                                ->rows(2),

                            Forms\Components\RichEditor::make('description')
                                ->required()
                                ->label('Açıklama'),

                            Grid::make(3)
                                ->schema([
                                    TextInput::make('base_price')
                                        ->label('Satış Fiyatı')
                                        ->numeric()
                                        ->required(),

                                    TextInput::make('compare_price')
                                        ->label('İndirim Öncesi Fiyat')
                                        ->numeric()
                                        ->nullable(),

                                    TextInput::make('cost')
                                        ->label('Maliyet')
                                        ->numeric()
                                        ->nullable(),
                                ]),
                            Grid::make(3)
                                ->schema([
                                    Toggle::make('status')
                                        ->label('Aktif')
                                        ->default(true),

                                    Toggle::make('is_featured')
                                        ->label('Öne Çıkar'),

                                    Toggle::make('is_new')
                                        ->label('Yeni Ürün'),
                                ]),
                            Forms\Components\Section::make('SEO')
                                ->schema([
                                    Grid::make(1)
                                        ->schema([
                                            TextInput::make('meta_title')
                                                ->label('Meta Başlık')
                                                ->maxLength(255),

                                            TextInput::make('meta_description')
                                                ->label('Meta Açıklama')
                                                ->maxLength(255),

                                            TextInput::make('meta_keywords')
                                                ->label('Meta Kelimeler')
                                                ->helperText('kelimeleri virgül ile ayırarak yazınız. (gümüş, prılanta, zirkon)')
                                                ->maxLength(255),
                                        ]),
                                ])->collapsed(),
                        ]),
                    Step::make('Varyantlar')
                        ->schema([
                            Repeater::make('variants')
                                ->relationship('variants')
                                ->label('Varyantlar')
                                ->schema([
                                    Grid::make(3)
                                        ->schema([
                                            TextInput::make('sku')->required(),
                                            TextInput::make('price')->numeric()->required(),
                                            TextInput::make('stock')->numeric()->required(),
                                        ]),

                                    Repeater::make('attributeVariants')
                                        ->relationship('attributeVariants')
                                        ->label('Varyant Özellikleri')
                                        ->schema([
                                            Select::make('attribute_id')
                                                ->label('Özellik')
                                                ->options(Attribute::query()->pluck('name', 'id'))
                                                ->reactive()
                                                ->afterStateUpdated(fn($state, callable $set) => $set('attribute_value_id', null))
                                                ->required(),

                                            Select::make('attribute_value_id')
                                                ->label('Değer')
                                                ->options(fn(callable $get) => AttributeValue::query()->where('attribute_id', $get('attribute_id'))->pluck('value', 'id'))
                                                ->required(),
                                        ])
                                        ->defaultItems(1)
                                        ->columns(2)
                                        ->addActionLabel('Özellik Ekle')
                                        ->collapsible(),
                                ])->addActionLabel('Varyant Ekle')

                        ]),
                    Step::make('Görseller')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('images')
                                ->label('Ürün Görselleri')
                                ->collection('products')
                                ->multiple()
                                ->reorderable()
                                ->image()
                                ->maxFiles(10)
                        ]),
                ])->skippable()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('products'))
                    ->circular(),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('base_price')
                    ->badge()
                    ->money('TRY')
                    ->sortable(),

                ToggleColumn::make('status')
                    ->label('Active')
                    ->sortable(),
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
