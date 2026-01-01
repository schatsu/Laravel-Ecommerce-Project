<?php

namespace App\Models;

use App\Enums\Admin\ProductVariationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class VariationType extends Model
{
    public $timestamps = false;

    use HasSlug;
    protected $fillable = [
       'product_id', 'name', 'slug', 'type',
    ];

    protected function casts(): array
    {
        return [
          'type' => ProductVariationType::class,
        ];
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

    public function options(): HasMany
    {
        return $this->hasMany(VariationTypeOption::class, 'variation_type_id');
    }
}
