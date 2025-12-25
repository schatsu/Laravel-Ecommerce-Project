<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{


    protected $fillable = [
        'name',
        'slug',
        'short_name',
        'native_name',
        'phone_code',
        'capital',
        'flag',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'timezones' => 'array',
        ];
    }

    public static function boot(): void
    {
        static::creating(function ($model) {
            $model->timestamps = false;
            $model->created_at = now();
        });

        parent::boot();
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
