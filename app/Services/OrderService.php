<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    public function createFromCart(Cart $cart, array $billingAddress, array $shippingAddress = null, float $shippingCost = 0): Order
    {
        return DB::transaction(function () use ($cart, $billingAddress, $shippingAddress, $shippingCost) {
            $cart->load('items.product', 'items.variation');
            
            $subtotal = $cart->subtotal;
            $total = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id' => $cart->user_id,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress ?? $billingAddress,
                'payment_method' => 'iyzico',
                'payment_status' => 'pending',
                'iyzico_conversation_id' => uniqid('conv_'),
            ]);

            foreach ($cart->items as $item) {
                $variationInfo = null;
                if ($item->variation) {
                    $options = $item->variation->selectedOptions();
                    $variationInfo = $options->map(fn($opt) => $opt->name)->implode(', ');
                }

                OrderItem::create([
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
            'status' => 'processing',
            'payment_status' => 'paid',
            'iyzico_payment_id' => $paymentId,
        ]);

        // Sepeti temizle
        $this->cartService->clear();

        return $order->fresh();
    }

    public function markAsFailed(Order $order): Order
    {
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed',
        ]);

        return $order->fresh();
    }
}
