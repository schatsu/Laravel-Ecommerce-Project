<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return $this->getUserCart();
        }

        return $this->getSessionCart();
    }

    protected function getUserCart(): Cart
    {
        return Cart::query()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => null]
        );
    }

    protected function getSessionCart(): Cart
    {
        $sessionId = Session::getId();

        return Cart::query()->firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    public function add(Product $product, ?ProductVariation $variation = null, int $quantity = 1): CartItem
    {
        $cart = $this->getCart();

        $unitPrice = $this->calculateUnitPrice($product, $variation);

        $existingItem = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_variation_id', $variation?->id)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            $existingItem->update(['unit_price' => $unitPrice]);
            return $existingItem->fresh();
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'product_variation_id' => $variation?->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
        ]);
    }

    public function update(CartItem $item, int $quantity): CartItem
    {
        if ($quantity <= 0) {
            $this->remove($item);
            return $item;
        }

        $item->update(['quantity' => $quantity]);
        return $item->fresh();
    }

    public function remove(CartItem $item): bool
    {
        return $item->delete();
    }

    public function clear(): bool
    {
        $cart = $this->getCart();
        return $cart->items()->delete() > 0;
    }

    public function getItemCount(): int
    {
        return $this->getCart()->item_count;
    }

    public function getSubtotal(): float
    {
        return $this->getCart()->subtotal;
    }

    public function mergeSessionCartToUser(): void
    {
        $sessionId = Session::getId();
        $sessionCart = Cart::query()->where('session_id', $sessionId)->first();

        if (!$sessionCart || $sessionCart->items->isEmpty()) {
            return;
        }

        $userCart = $this->getUserCart();

        foreach ($sessionCart->items as $sessionItem) {
            $existingItem = $userCart->items()
                ->where('product_id', $sessionItem->product_id)
                ->where('product_variation_id', $sessionItem->product_variation_id)
                ->first();

            if ($existingItem) {
                $existingItem->increment('quantity', $sessionItem->quantity);
            } else {
                $userCart->items()->create([
                    'product_id' => $sessionItem->product_id,
                    'product_variation_id' => $sessionItem->product_variation_id,
                    'quantity' => $sessionItem->quantity,
                    'unit_price' => $sessionItem->unit_price,
                ]);
            }
        }

        $sessionCart->delete();
    }

    protected function calculateUnitPrice(Product $product, ?ProductVariation $variation): float
    {
        if ($variation) {
            $discountPrice = (float) $variation->discount_price;
            $sellingPrice = (float) $variation->selling_price;
            
            return ($discountPrice > 0 && $discountPrice < $sellingPrice)
                ? $discountPrice
                : $sellingPrice;
        }

        $discountPrice = (float) $product->discount_price;
        $sellingPrice = (float) $product->selling_price;
        
        return ($discountPrice > 0 && $discountPrice < $sellingPrice)
            ? $discountPrice
            : $sellingPrice;
    }
}
