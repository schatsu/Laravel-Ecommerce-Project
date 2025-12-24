<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected static ?string $navigationLabel = "Ürünü Düzenle";

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('variations')
                ->label('Varyasyonları Düzenle')
                ->icon('heroicon-o-queue-list')
                ->color('info')
                ->url(fn () => ProductResource::getUrl('product-variations', ['record' => $this->record]))
                ->visible(fn () => $this->record->variationTypes()->exists()),
            Actions\DeleteAction::make(),
        ];
    }
}
