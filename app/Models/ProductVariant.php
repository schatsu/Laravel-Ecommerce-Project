<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'compare_price',
        'cost',
        'stock',
        'barcode',
        'weight',
        'weight_unit',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost' => 'decimal:2',
            'stock' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeVariants(): HasMany
    {
        return $this->hasMany(AttributeVariant::class, 'product_variant_id');
    }

    public function attributeValues(): HasManyThrough
    {
        return $this->hasManyThrough(
            AttributeValue::class,
            AttributeVariant::class,
            'product_variant_id',
            'id',
            'id',
            'attribute_value_id'
        );
    }
}
