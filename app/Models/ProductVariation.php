<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
