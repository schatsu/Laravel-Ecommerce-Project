<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'slug',
        'code',
    ];

    public static function boot(): void
    {
        static::creating(function ($model) {
            $model->timestamps = false;
            $model->created_at = now();
        });

        parent::boot();
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
