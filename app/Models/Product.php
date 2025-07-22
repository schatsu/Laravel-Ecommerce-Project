<?php

namespace App\Models;

use App\Enums\Admin\ProductStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtvs\EloquentHashids\HasHashid;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasSlug, HasHashid;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'base_price',
        'compare_price',
        'cost',
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
            'base_price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost' => 'decimal:2',
            'status' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_best_seller' => 'boolean',
        ];
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Crop, 720, 1005)
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

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', ProductStatusEnum::PUBLISHED);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
