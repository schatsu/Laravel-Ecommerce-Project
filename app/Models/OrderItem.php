<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variation_id',
        'name',
        'variation_info',
        'quantity',
        'unit_price',
        'total',
    ];


    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->variation) {
            // Önce preloadedOptions'ı kontrol et (N+1 query çözümü için)
            $options = $this->relationLoaded('preloadedOptions')
                ? $this->getRelation('preloadedOptions')
                : $this->variation->selectedOptions();

            foreach ($options as $option) {
                if ($option->variationType?->type === \App\Enums\Admin\ProductVariationType::IMAGE) {
                    $mediaUrl = $option->getFirstMediaUrl('images', 'small');
                    if ($mediaUrl) {
                        return $mediaUrl;
                    }
                }
            }
        }

        return $this->product?->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png');
    }
}
