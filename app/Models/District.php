<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{

    protected $fillable = [
        'city_id',
        'name',
        'slug',
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
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
