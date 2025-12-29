<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public ?string $type = 'simple';

    public function mount(): void
    {
        parent::mount();
        $this->type = request()->query('type', 'simple');
    }

    public function getTitle(): string|Htmlable
    {
        return $this->type === 'variable' ? 'Varyantlı Ürün Ekle' : 'Basit Ürün Ekle';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Geri')
                ->icon('heroicon-o-arrow-left')
                ->url(ProductResource::getUrl()),
        ];
    }
}
