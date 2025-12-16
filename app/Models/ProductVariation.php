<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'variation_type_option_ids',
        'selling_price',
        'cost_price',
        'discount_price',
        'sku',
        'stock_quantity',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'variation_type_option_ids' => 'json',
            'is_active' => 'boolean',
            'stock_quantity' => 'integer',
            'selling_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'discount_price' => 'decimal:2',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function selectedOptions()
    {
        return VariationTypeOption::whereIn('id', $this->variation_type_option_ids ?? [])->get();
    }
}
