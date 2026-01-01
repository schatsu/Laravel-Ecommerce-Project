<?php

namespace App\Models;

use App\Enums\Admin\CouponType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];


    protected function casts(): array
    {
        return [
            'type' => CouponType::class,
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'usage_limit_per_user' => 'integer',
            'used_count' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function isValidForUser(?int $userId): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($userId && $this->usage_limit_per_user) {
            $userUsageCount = $this->usages()->where('user_id', $userId)->count();
            if ($userUsageCount >= $this->usage_limit_per_user) {
                return false;
            }
        }

        return true;
    }

    public function isValidForAmount(float $amount): bool
    {
        if ($this->min_order_amount && $amount < (float) $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if (!$this->isValidForAmount($subtotal)) {
            return 0;
        }

        $discount = match($this->type) {
            CouponType::PERCENTAGE => $subtotal * ((float) $this->value / 100),
            CouponType::FIXED => (float) $this->value,
        };


        if ($this->max_discount_amount && $discount > (float) $this->max_discount_amount) {
            $discount = (float) $this->max_discount_amount;
        }


        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        return round($discount, 2);
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    public function getFormattedValueAttribute(): string
    {
        return match($this->type) {
            CouponType::PERCENTAGE => '%' . number_format($this->value, 0),
            CouponType::FIXED => number_format($this->value, 2, ',', '.') . ' ₺',
        };
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'Pasif';
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return 'Henüz Başlamadı';
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'Süresi Doldu';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'Limit Doldu';
        }

        return 'Aktif';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Aktif' => 'success',
            'Pasif' => 'gray',
            'Henüz Başlamadı' => 'info',
            'Süresi Doldu', 'Limit Doldu' => 'danger',
            default => 'gray',
        };
    }
}
