<?php

namespace App\Filament\Resources;

use App\Enums\Admin\CategoryStatusEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationGroup = 'E-Ticaret';
    protected static ?int $navigationSort = 1;
    protected static ?string $label = 'Kategori';
    protected static ?string $pluralLabel = 'Kategoriler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Genel Bilgiler')
                    ->collapsible()
                    ->schema([
                        Select::make('parent_id')
                            ->label('Üst Kategori')
                            ->relationship('parent', 'name')
                            ->preload()
                            ->searchable()
                            ->nullable()
                            ->columnSpanFull(),

                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Kategori Adı')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(Category::class, 'slug', ignorable: fn($record) => $record)
                                    ->maxLength(255),
                            ]),

                        FileUpload::make('image')
                            ->label('Kategori Görseli')
                            ->image()
                            ->directory('categories')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Açıklama')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(),

                Forms\Components\Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Başlık')
                            ->maxLength(255),
                        TextInput::make('meta_keywords')
                            ->label('Meta Anahtar Kelimeler')
                            ->placeholder('örneğin: kolye, yüzük, bileklik')
                            ->hint('Anahtar kelimeleri virgülle ayırın.')
                            ->maxLength(255),
                        Textarea::make('meta_description')
                            ->label('Meta Açıklama')
                            ->columnSpanFull(2),
                    ])
                    ->columns(),

                Forms\Components\Section::make('Ayarlar')
                    ->collapsed()
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('order')
                                ->label('Sıra')
                                ->required()
                                ->numeric()
                                ->default(fn() => Category::query()->max('order') + 1)
                                ->minValue(1),

                            Select::make('status')
                                ->label('Durum')
                                ->options([
                                    CategoryStatusEnum::ACTIVE->value => 'Aktif',
                                    CategoryStatusEnum::PASSIVE->value => 'Pasif',
                                ])
                                ->nullable(),
                        ]),

                        Grid::make(3)->schema([
                            Toggle::make('is_featured')
                                ->label('Vitrin')
                                ->reactive(),

                            Toggle::make('is_landing')
                                ->label('Landing')
                                ->reactive(),

                            Toggle::make('is_collection')
                                ->label('Koleksiyon')
                                ->reactive(),
                        ]),

                        FileUpload::make('featured_cover_image')
                            ->label('Vitrin Kapak Görseli')
                            ->hint('Önerilen boyut: 160x160')
                            ->image()
                            ->directory('categories/featured')
                            ->hidden(fn(Get $get) => !$get('is_featured')),

                        FileUpload::make('landing_cover_image')
                            ->label('Landing Kapak Görseli')
                            ->hint('Önerilen boyut: 360x432')
                            ->image()
                            ->directory('categories/landing')
                            ->hidden(fn(Get $get) => !$get('is_landing')),

                        FileUpload::make('collection_cover_image')
                            ->label('Koleksiyon Kapak Görseli')
                            ->hint('Önerilen boyut: 800x746')
                            ->image()
                            ->directory('categories/collection')
                            ->hidden(fn(Get $get) => !$get('is_collection')),

                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Görsel')
                    ->square()
                    ->size(50),

                TextColumn::make('name')
                    ->label('Kategori Adı')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.name')
                    ->label('Üst Kategori')
                    ->sortable()
                    ->badge()
                    ->state(fn($record) => $record->parent?->name ?? 'Yok')
                    ->color(fn($state) => $state === 'Yok' ? 'gray' : 'blue'),
                TextColumn::make('status')
                    ->label('Durum')
                    ->sortable()
                    ->badge()
                    ->state(function ($record) {
                        if ($record->status === null) {
                            return 'Belirsiz';
                        }
                        return match ($record->status) {
                            CategoryStatusEnum::ACTIVE => 'Aktif',
                            CategoryStatusEnum::PASSIVE => 'Pasif',
                            default => 'Belirsiz',
                        };
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            'Aktif' => 'success',
                            'Pasif' => 'danger',
                            'Belirsiz' => 'gray',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('order')
                    ->label('Sıra')
                    ->sortable(),
                TextColumn::make('is_featured')
                    ->label('Vitrin')
                    ->sortable()
                    ->badge()
                    ->state(function ($record) {
                        if ($record->is_featured === null) {
                            return 'Belirsiz';
                        }
                        return $record->is_featured ? 'Aktif' : 'Pasif';
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            'Aktif' => 'success',
                            'Pasif' => 'danger',
                            'Belirsiz' => 'gray',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('is_landing')
                    ->label('Landing')
                    ->sortable()
                    ->badge()
                    ->state(fn($record) => $record->is_landing ? 'Aktif' : 'Pasif')
                    ->color(fn($state) => $state === 'Aktif' ? 'success' : 'danger'),

                TextColumn::make('is_collection')
                    ->label('Koleksiyon')
                    ->sortable()
                    ->badge()
                    ->state(fn($record) => $record->is_collection ? 'Aktif' : 'Pasif')
                    ->color(fn($state) => $state === 'Aktif' ? 'success' : 'danger'),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options(CategoryStatusEnum::labels()),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
            ? strval(static::getEloquentQuery()->count())
            : null;
    }
}
