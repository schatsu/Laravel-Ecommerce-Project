<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variation_id',
        'quantity',
        'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }

    public function getDisplayNameAttribute(): string
    {
        $name = $this->product->name;

        if ($this->variation) {
            $options = $this->variation->selectedOptions();
            if ($options->isNotEmpty()) {
                $name .= ' - ' . $options->pluck('name')->implode(' / ');
            }
        }

        return $name;
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->variation) {
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
