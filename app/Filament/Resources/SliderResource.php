<?php

namespace App\Filament\Resources;

use App\Enums\Admin\SliderStatusEnum;
use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Site';
    protected static ?int $navigationSort = 1;
    protected static ?string $label = 'Slider';
    protected static ?string $pluralLabel = 'Slider';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Slider Bilgileri')
                    ->description('Slider içeriği ve ayarlarını buradan düzenleyebilirsiniz.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Başlık')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('subtitle')
                                    ->label('Alt Başlık')
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('link_title')
                                    ->label('Buton Başlığı')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('link_url')
                                    ->label('Buton URL')
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('order')
                                    ->label('Sıralama')
                                    ->required()
                                    ->numeric()
                                    ->default(1),

                                Forms\Components\Select::make('status')
                                    ->label('Durum')
                                    ->options([
                                        SliderStatusEnum::ACTIVE->value => 'Aktif',
                                        SliderStatusEnum::PASSIVE->value => 'Pasif',
                                    ])
                                    ->required()
                                    ->default(SliderStatusEnum::ACTIVE->value),
                            ]),

                        Forms\Components\FileUpload::make('image')
                            ->label('Görsel')
                            ->image()
                            ->directory('sliders')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Alt Başlık')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Slider'),
                Tables\Columns\TextColumn::make('link_title')
                    ->label('Buton adı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_url')
                    ->label('Buton URL')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Sıra')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($record) => match ($record->status) {
                        SliderStatusEnum::PASSIVE => 'gray',
                        SliderStatusEnum::ACTIVE => 'success',
                        default => 'indigo',
                    })
                    ->state(fn($record) => match ($record->status) {
                        SliderStatusEnum::PASSIVE => 'Pasif',
                        SliderStatusEnum::ACTIVE => 'Aktif',
                        default => 'Belirsiz',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturma Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncelleme Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options(SliderStatusEnum::labels()),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
            ? strval(static::getEloquentQuery()->count())
            : null;
    }
}
