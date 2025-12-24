<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->items->sum('total');
    }

    public function getDiscountAmountAttribute(): float
    {
        if (!$this->coupon || !$this->coupon->isValidForUser($this->user_id)) {
            return 0;
        }

        return $this->coupon->calculateDiscount($this->subtotal);
    }

    public function getTotalAttribute(): float
    {
        return max(0, $this->subtotal - $this->discount_amount);
    }

    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    public function getIsEmptyAttribute(): bool
    {
        return $this->items->isEmpty();
    }

    public function applyCoupon(Coupon $coupon): bool
    {
        if (!$coupon->isValidForUser($this->user_id)) {
            return false;
        }

        if (!$coupon->isValidForAmount($this->subtotal)) {
            return false;
        }

        $this->update(['coupon_id' => $coupon->id]);
        return true;
    }

    public function removeCoupon(): void
    {
        $this->update(['coupon_id' => null]);
    }
}

