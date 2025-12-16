<?php

namespace App\Models;

use App\Enums\Admin\CategoryStatusEnum;
use App\Observers\CategoryObserver;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model implements HasMedia
{
    use InteractsWithMedia, Filterable;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'status',
        'order',
        'is_featured',
        'is_landing',
        'is_collection',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'status' => CategoryStatusEnum::class,
            'order' => 'integer',
            'is_featured' => 'boolean',
            'is_landing' => 'boolean',
            'is_collection' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        if ($media && $media->collection_name === 'featured_cover') {
            $this->addMediaConversion('featured_cover')
                ->fit(Fit::Crop, 400, 400)
                ->format('webp')
                ->optimize()
                ->nonQueued();
        }

        if ($media && $media->collection_name === 'landing_cover') {
            $this->addMediaConversion('landing_cover')
                ->fit(Fit::Crop, 360, 432)
                ->format('webp')
                ->optimize()
                ->nonQueued();
        }

        if ($media && $media->collection_name === 'collection_cover') {
            $this->addMediaConversion('collection_cover')
                ->fit(Fit::Crop, 800, 746)
                ->format('webp')
                ->optimize()
                ->nonQueued();
        }
    }

}
