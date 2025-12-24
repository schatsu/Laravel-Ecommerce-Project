<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;

class CouponService
{
    public function findByCode(string $code): ?Coupon
    {
        return Coupon::where('code', strtoupper(trim($code)))->first();
    }

    public function validateCoupon(string $code, Cart $cart): array
    {
        $coupon = $this->findByCode($code);

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'Kupon kodu bulunamadı.',
            ];
        }

        if (!$coupon->is_active) {
            return [
                'success' => false,
                'message' => 'Bu kupon aktif değil.',
            ];
        }

        if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
            return [
                'success' => false,
                'message' => 'Bu kupon henüz kullanıma açılmadı.',
            ];
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return [
                'success' => false,
                'message' => 'Bu kuponun süresi dolmuş.',
            ];
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return [
                'success' => false,
                'message' => 'Bu kuponun kullanım limiti dolmuş.',
            ];
        }

        if ($cart->user_id && $coupon->usage_limit_per_user) {
            $userUsageCount = $coupon->usages()->where('user_id', $cart->user_id)->count();
            if ($userUsageCount >= $coupon->usage_limit_per_user) {
                return [
                    'success' => false,
                    'message' => 'Bu kuponu daha fazla kullanamazsınız.',
                ];
            }
        }

        $subtotal = $cart->subtotal;
        if ($coupon->min_order_amount && $subtotal < (float) $coupon->min_order_amount) {
            $minAmount = number_format($coupon->min_order_amount, 2, ',', '.');
            return [
                'success' => false,
                'message' => "Bu kupon için minimum sepet tutarı {$minAmount} ₺ olmalıdır.",
            ];
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return [
            'success' => true,
            'message' => 'Kupon uygulandı!',
            'coupon' => $coupon,
            'discount' => $discount,
        ];
    }

    public function applyCoupon(string $code, Cart $cart): array
    {
        $validation = $this->validateCoupon($code, $cart);

        if (!$validation['success']) {
            return $validation;
        }

        $cart->update(['coupon_id' => $validation['coupon']->id]);

        return [
            'success' => true,
            'message' => $validation['message'],
            'discount' => $validation['discount'],
            'coupon' => [
                'code' => $validation['coupon']->code,
                'name' => $validation['coupon']->name,
                'formatted_value' => $validation['coupon']->formatted_value,
            ],
        ];
    }

    public function removeCoupon(Cart $cart): array
    {
        $cart->update(['coupon_id' => null]);

        return [
            'success' => true,
            'message' => 'Kupon kaldırıldı.',
        ];
    }

    public function recordUsage(Coupon $coupon, Order $order): void
    {
        CouponUsage::create([
            'coupon_id' => $coupon->id,
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'discount_amount' => $order->discount_amount,
        ]);

        $coupon->incrementUsage();
    }
}
