<?php

namespace App\Filament\Resources;

use App\Enums\Admin\CategoryStatusEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use BezhanSalleh\FilamentShield\Support\Utils;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
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
        return $form->schema([
            Wizard::make([
                Step::make('Genel Bilgiler')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Select::make('parent_id')
                            ->label('Üst Kategori')
                            ->relationship('parent', 'name')
                            ->preload()
                            ->searchable()
                            ->nullable()
                            ->columnSpanFull(),

                        Grid::make()->schema([
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

                        Textarea::make('description')
                            ->label('Açıklama')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Step::make('Ayarlar')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('order')
                                ->label('Sıra')
                                ->numeric()
                                ->default(fn() => Category::query()->max('order') + 1)
                                ->minValue(1)
                                ->required(),

                            Select::make('status')
                                ->label('Durum')
                                ->options([
                                    CategoryStatusEnum::ACTIVE->value => 'Aktif',
                                    CategoryStatusEnum::PASSIVE->value => 'Pasif',
                                ])
                                ->nullable(),
                        ]),

                        Grid::make(3)->schema([
                            Toggle::make('is_featured')->label('Vitrin')->reactive(),
                            Toggle::make('is_landing')->label('Landing')->reactive(),
                            Toggle::make('is_collection')->label('Koleksiyon')->reactive(),
                        ]),

                        SpatieMediaLibraryFileUpload::make('featured_cover')
                            ->label('Vitrin Kapak Görseli')
                            ->collection('featured_cover')
                            ->image()
                            ->hint('Önerilen boyut: 160x160')
                            ->hidden(fn(Get $get) => !$get('is_featured')),

                        SpatieMediaLibraryFileUpload::make('landing_cover')
                            ->label('Landing Kapak Görseli')
                            ->collection('landing_cover')
                            ->image()
                            ->hint('Önerilen boyut: 360x432')
                            ->hidden(fn(Get $get) => !$get('is_landing')),

                        SpatieMediaLibraryFileUpload::make('collection_cover')
                            ->label('Koleksiyon Kapak Görseli')
                            ->collection('collection_cover')
                            ->image()
                            ->hint('Önerilen boyut: 800x746')
                            ->hidden(fn(Get $get) => !$get('is_collection')),
                    ]),

                Step::make('SEO')
                    ->icon('heroicon-o-globe-alt')
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
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ])
                ->skippable()
                ->columnSpanFull(),
        ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->toggleable(isToggledHiddenByDefault: true)
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
                    ->color(fn($state) => $state === 'Aktif' ? 'success' : 'danger')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('is_collection')
                    ->label('Koleksiyon')
                    ->sortable()
                    ->badge()
                    ->state(fn($record) => $record->is_collection ? 'Aktif' : 'Pasif')
                    ->color(fn($state) => $state === 'Aktif' ? 'success' : 'danger')
                    ->toggleable(isToggledHiddenByDefault: true),
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
