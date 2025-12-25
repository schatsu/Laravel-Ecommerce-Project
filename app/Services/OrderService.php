<?php

namespace App\Services;

use App\Enums\Admin\OrderPaymentStatusEnum;
use App\Enums\Admin\OrderStatusEnum;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * @throws Throwable
     */
    public function createFromCart(Cart $cart, array $billingAddress, array $shippingAddress = null, float $shippingCost = 0): Order
    {
        return DB::transaction(function () use ($cart, $billingAddress, $shippingAddress, $shippingCost) {
            $cart->load('items.product', 'items.variation', 'coupon');

            $subtotal = $cart->subtotal;
            $discountAmount = $cart->discount_amount ?? 0;
            $total = $subtotal - $discountAmount + $shippingCost;

            $order = Order::query()->create([
                'user_id' => $cart->user_id,
                'order_number' => Order::generateOrderNumber(),
                'status' => OrderStatusEnum::PENDING,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount_amount' => $discountAmount,
                'coupon_id' => $cart->coupon_id,
                'total' => $total,
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress ?? $billingAddress,
                'payment_method' => 'iyzico',
                'payment_status' => OrderPaymentStatusEnum::PENDING,
                'iyzico_conversation_id' => uniqid('conv_'),
            ]);

            foreach ($cart->items as $item) {
                $variationInfo = null;
                if ($item->variation) {
                    $options = $item->variation->selectedOptions();
                    $variationInfo = $options->map(fn($opt) => $opt->name)->implode(', ');
                }

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variation_id' => $item->product_variation_id,
                    'name' => $item->product->name,
                    'variation_info' => $variationInfo,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->total,
                ]);
            }

            return $order->load('items');
        });
    }

    public function markAsPaid(Order $order, string $paymentId): Order
    {
        $order->update([
            'status' => OrderStatusEnum::PROCESSING,
            'payment_status' => OrderPaymentStatusEnum::PAID,
            'iyzico_payment_id' => $paymentId,
        ]);

        // Kullanıcının sepetini temizle (session bağımlı olmadan)
        $this->cartService->clearByUserId($order->user_id);

        return $order->fresh();
    }

    public function markAsFailed(Order $order): Order
    {
        $order->update([
            'status' => OrderStatusEnum::CANCELLED,
            'payment_status' => OrderPaymentStatusEnum::FAILED,
        ]);

        return $order->fresh();
    }
}
