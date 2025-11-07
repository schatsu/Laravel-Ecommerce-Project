<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Dflydev\DotAccessData\Data;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class ProductVariations extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected static ?string $navigationLabel = 'Ürün Varyasyonları';

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        $types = $this->record->variationTypes;
        $fields = [];

        foreach ($types as $type) {
            $fields[] = Hidden::make('variation_type_' . $type->id . '.id')
                ->default($type->id);
            $fields[] = TextInput::make('variation_type_' . ($type?->id) . '.name')
                ->label($type?->name);
        }
        return $form
            ->schema([
                Repeater::make('variations')
                    ->collapsible()
                    ->addable(false)
                    ->defaultItems(1)
                    ->schema([
                        Section::make()
                            ->schema($fields)
                            ->columns(3),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('cost_price')
                                    ->label('Alış Fiyatı')
                                    ->nullable()
                                    ->prefix('₺')
                                    ->numeric(),
                                TextInput::make('selling_price')
                                    ->label('Satış Fiyatı')
                                    ->required()
                                    ->prefix('₺')
                                    ->numeric(),
                                TextInput::make('discount_price')
                                    ->label('İndirimli Satış Fiyatı')
                                    ->nullable()
                                    ->prefix('₺')
                                    ->numeric(),
                                TextInput::make('sku')
                                    ->label('Stok Kodu')
                                    ->required(),
                                TextInput::make('stock_quantity')
                                    ->label('Stok Adeti')
                                    ->required()
                                    ->numeric(),
                                Select::make('is_active')
                                    ->label('Durum')
                                    ->default(true)
                                    ->options([
                                        1 => 'Aktif',
                                        0 => 'Pasif',
                                    ]),
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpan(2)
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $variations = $this->record->variations?->toArray();
        $data['variations'] = $this->mergeCartesianWithExisting($this->record->variationTypes, $variations);
        return $data;
    }

    private function mergeCartesianWithExisting($variationsTypes, $existingData): array
    {
        $defaultPrice = $this->record->selling_price ?? 0;
        $discountPrice = $this->record->discount_price ?? 0;
        $costPrice = $this->record->cost_price ?? 0;
        $sku = $this->record->sku ?? 0;
        $stockQuantity = $this->record->stock_quantity ?? 0;
        $isActive = $this->record?->is_active ?? false;
        $cartesianProduct = $this->cartesianProduct($variationsTypes, $defaultPrice, $discountPrice, $costPrice, $sku, $stockQuantity, $isActive);
        $mergedResult = [];

        foreach ($cartesianProduct as $product) {
            $optionIds = collect($product)
                ->filter(fn($value, $key) => str_starts_with($key, 'variation_type_'))
                ->map(fn($option) => $option['id'])
                ->values()
                ->toArray();

            $match = array_filter($existingData, function ($existingOption) use ($optionIds) {
                return $existingOption['variation_type_option_ids'] === $optionIds;
            });

            if (!empty($match)) {
                $existingEntry = reset($match);
                $product['selling_price'] = $existingEntry['selling_price'];
                $product['discount_price'] = $existingEntry['discount_price'];
                $product['cost_price'] = $existingEntry['cost_price'];
                $product['sku'] = $existingEntry['sku'];
                $product['stock_quantity'] = $existingEntry['stock_quantity'];
                $product['is_active'] = $existingEntry['is_active'];
            } else {
                $product['selling_price'] = $defaultPrice;
                $product['discount_price'] = $discountPrice;
                $product['cost_price'] = $costPrice;
                $product['sku'] = $sku;
                $product['stock_quantity'] = $stockQuantity;
                $product['is_active'] = $isActive;
            }

            $mergedResult[] = $product;
        }
        return $mergedResult;
    }

    private function cartesianProduct($variationsTypes, $defaultPrice = null, $discountPrice = null, $costPrice = null, $sku = null, $stockQuantity = null, $isActive = false ): array
    {
        $result = [[]];

        foreach ($variationsTypes as $index => $variationType) {
            $temp = [];
            foreach ($variationType->options as $option) {
                foreach ($result as $combination) {
                    $newCombination = $combination + [
                            'variation_type_' . ($variationType?->id) => [
                                'id' => $option?->id,
                                'name' => $option?->name,
                                'label' => $variationType?->name,
                            ],
                        ];

                    $temp[] = $newCombination;
                }
            }
            $result = $temp;
        }

        foreach ($result as &$combination) {
            if (count($combination) === count($variationsTypes)) {
                $combination['selling_price'] = $defaultPrice;
                $combination['discount_price'] = $discountPrice;
                $combination['cost_price'] = $costPrice;
                $combination['sku'] = $sku;
                $combination['stock_quantity'] = $stockQuantity;
                $combination['isActive'] = $isActive;
            }
        }
        return $result;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $formattedData = [];

        foreach ($data['variations'] as $option) {
            $variationTypeOptionIds = [];
            foreach ($this->record->variationTypes as $i => $variationType) {
                $variationTypeOptionIds[] = $option['variation_type_' . ($variationType?->id)]['id'];
            }
            $price = $option['selling_price'];
            $costPrice = $option['cost_price'];
            $discountPrice = $option['discount_price'];

            $formattedData[] = [
                'variation_type_option_ids' => $variationTypeOptionIds,
                'selling_price' => $price,
                'cost_price' => $costPrice,
                'discount_price' => $discountPrice,
                'sku' => $option['sku'] ?? null,
                'stock_quantity' => $option['stock_quantity'] ?? 0,
                'is_active' => $option['is_active'] ?? true,
            ];

        }
        $data['variations'] = $formattedData;
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $variations = $data['variations'];
        unset($data['variations']);

        $record->update($data);
        $record->variations()->delete();
        $record->variations()->createMany($variations);

        return $record;
    }
}
