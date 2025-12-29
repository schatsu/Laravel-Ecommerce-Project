<?php

namespace App\Models;

use App\Enums\Admin\ProductStatusEnum;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Multicaret\Acquaintances\Traits\CanBeFavorited;
use Mtvs\EloquentHashids\HasHashid;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasSlug, HasHashid, Filterable, CanBeFavorited;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'selling_price',
        'cost_price',
        'discount_price',
        'sku',
        'stock_quantity',
        'status',
        'is_featured',
        'is_new',
        'is_best_seller',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'selling_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'status' => ProductStatusEnum::class,
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_best_seller' => 'boolean',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->nonQueued();
        $this->addMediaConversion('small')
            ->width(480)
            ->nonQueued();
        $this->addMediaConversion('large')
            ->width(1200)
            ->nonQueued();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn($model) => $model?->slug ?? $model?->name ?? '')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function variationTypes(): HasMany
    {
        return $this->hasMany(VariationType::class);
    }

    public function options(): HasManyThrough|Product
    {
        return $this->hasManyThrough(
            VariationTypeOption::class,
            VariationType::class,
            'product_id',
            'variation_type_id',
            'id',
            'id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', ProductStatusEnum::PUBLISHED);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }


    public function getDisplayPriceAttribute(): float
    {
        if ($this->variations->count() > 0) {
            return $this->variations->map(function ($v) {
                return $v->discount_price > 0 ? $v->discount_price : $v->selling_price;
            })->min();
        }

        return $this->discount_price > 0 ? $this->discount_price : $this->selling_price;
    }


    public function getDisplayOriginalPriceAttribute(): ?float
    {
        if ($this->variations->count() > 0) {
            $lowestPrice = $this->display_price;
            $lowestVariation = $this->variations->first(function ($v) use ($lowestPrice) {
                $effectivePrice = $v->discount_price > 0 ? $v->discount_price : $v->selling_price;
                return $effectivePrice == $lowestPrice;
            });

            if ($lowestVariation && $lowestVariation->discount_price > 0) {
                return $lowestVariation->selling_price;
            }

            return null;
        }

        return $this->discount_price > 0 ? $this->selling_price : null;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->display_original_price !== null;
    }
}
