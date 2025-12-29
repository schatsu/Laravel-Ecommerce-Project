<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Forms\Components\Radio;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')
                ->label('Ürün Ekle')
                ->icon('heroicon-o-plus')
                ->modalHeading('Ürün Ekle')
                ->modalDescription('Eklemek istediğiniz ürün türünü seçin')
                ->modalWidth('lg')
                ->modalIcon('heroicon-o-information-circle')
                ->form([
                    Radio::make('product_type')
                        ->label('')
                        ->options([
                            'simple' => 'Basit Ürün',
                            'variable' => 'Varyantlı Ürün',
                        ])
                        ->descriptions([
                            'simple' => 'Tek parça olarak bir ürün ekleyin',
                            'variable' => 'Beden, renk gibi farklı özelliklerde birden fazla ürün ekleyin',
                        ])
                        ->default('simple')
                        ->required()
                        ->inline(false),
                ])
                ->modalSubmitActionLabel('Ürün Ekle')
                ->action(function (array $data) {
                    $type = $data['product_type'];
                    return redirect()->to(ProductResource::getUrl('create', ['type' => $type]));
                }),
        ];
    }
}
