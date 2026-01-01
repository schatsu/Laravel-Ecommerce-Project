<?php

namespace App\Models;

use App\Enums\Admin\ReviewStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'title',
        'content',
        'rating',
        'status',
        'admin_reply',
        'admin_replied_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'status' => ReviewStatusEnum::class,
            'admin_replied_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', ReviewStatusEnum::APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', ReviewStatusEnum::PENDING);
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
