<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\ProductVariationType;
use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class ProductVariationTypes extends EditRecord
{
    protected static string $resource = ProductResource::class;
    protected static ?string $navigationLabel = 'Ürün Özellikleri';
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ürün Özellikleri')
                ->schema([
                    Repeater::make('variationTypes')
                        ->label('Özellik Türleri')
                        ->relationship()
                        ->collapsible()
                        ->addActionLabel('Özellik Ekle')
                        ->defaultItems(1)
                        ->schema([
                            TextInput::make('name')
                                ->label('Özellik Adı')
                                ->required()
                                ->maxLength(255),
                            Select::make('type')
                                ->label('Özellik Tipi')
                                ->options(ProductVariationType::labels()),
                            Repeater::make('options')
                                ->label('Değerler')
                                ->defaultItems(1)
                                ->relationship()
                                ->collapsible()
                                ->addActionLabel('Değer Ekle')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Özellik Adı')
                                        ->required(),
                                    SpatieMediaLibraryFileUpload::make('images')
                                        ->label('Görseller')
                                        ->image()
                                        ->multiple()
                                        ->openable()
                                        ->panelLayout('grid')
                                        ->collection('images')
                                        ->reorderable()
                                        ->appendFiles()
                                        ->preserveFilenames()
                                        ->columnSpan(2)
                                ])

                        ])->columnSpan(2)
                ])
            ]);
    }
}
