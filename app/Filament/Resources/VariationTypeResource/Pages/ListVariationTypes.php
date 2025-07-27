<?php

namespace App\Filament\Resources\VariationTypeResource\Pages;

use App\Filament\Resources\VariationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVariationTypes extends ListRecords
{
    protected static string $resource = VariationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
