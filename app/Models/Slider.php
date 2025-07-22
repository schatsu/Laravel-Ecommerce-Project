<?php

namespace App\Models;

use App\Enums\Admin\SliderStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slider extends Model
{
    protected $fillable = [
      'title', 'subtitle', 'link_title',
      'link_url', 'image', 'order', 'status'
    ];

    protected function casts(): array
    {
        return [
            'status' => SliderStatusEnum::class,
            'order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::created(function () {
           Cache::forget('sliders');
        });
        static::updated(function () {
            Cache::forget('sliders');
        });
        static::deleted(function () {
           Cache::forget('sliders');
        });

        parent::booted();
    }
}
