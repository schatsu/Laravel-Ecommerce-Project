<?php

namespace App\Models;

use App\Enums\Admin\CategoryStatusEnum;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'status',
        'order',
        'is_featured',
        'is_landing',
        'is_collection',
        'landing_cover_image',
        'featured_cover_image',
        'collection_cover_image',
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

    public function getImageUrlAttribute(): string
    {
        if ($this->image)
        {
            return 'storage/'. $this->image;
        }

        return 'https://placehold.co/400';
    }

}
