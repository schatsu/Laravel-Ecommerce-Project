<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class VariationTypeOption extends Model implements HasMedia
{
    public $timestamps = false;

    use InteractsWithMedia, HasSlug;

    protected $fillable = [
        'variation_type_id', 'name', 'slug'
    ];

    public function variationType(): BelongsTo
    {
        return $this->belongsTo(VariationType::class, 'variation_type_id');
    }

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn($model) => $model?->slug ?? $model?->name ?? '')
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100);
        $this->addMediaConversion('small')
            ->width(480);
        $this->addMediaConversion('large')
            ->width(1200);
    }
}
