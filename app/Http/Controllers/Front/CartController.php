<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreCartRequest;
use App\Http\Requests\Front\UpdateCartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\Services\CouponService;
use App\Traits\Responder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    use Responder;

    public function __construct(
        private readonly CartService $cartService,
        private readonly CouponService $couponService
    ) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.product.media', 'items.variation', 'coupon');

        return view('app.cart.index', compact('cart'));
    }

    public function show(): JsonResponse
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.product.media', 'items.variation', 'coupon');

        return $this->success(
            CartResource::make($cart)
        );
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $cart = $this->cartService->getCart();
        $result = $this->couponService->applyCoupon($request->code, $cart);

        if (!$result['success']) {
            return $this->validationError(null, $result['message']);
        }

        $cart->refresh();
        $cart->load('coupon');

        return $this->success([
            'discount' => number_format($cart->discount_amount, 2, ',', '.'),
            'discount_raw' => $cart->discount_amount,
            'total' => number_format($cart->total, 2, ',', '.'),
            'total_raw' => $cart->total,
            'coupon' => $result['coupon'],
        ], $result['message']);
    }

    public function removeCoupon(): JsonResponse
    {
        $cart = $this->cartService->getCart();
        $this->couponService->removeCoupon($cart);

        $cart->refresh();

        return $this->success([
            'subtotal' => number_format($cart->subtotal, 2, ',', '.'),
            'total' => number_format($cart->total, 2, ',', '.'),
        ], 'Kupon kaldırıldı.');
    }

    public function store(StoreCartRequest $request): JsonResponse
    {
        $product   = $request->getProduct();
        $variation = $request->getVariation();
        $quantity  = $request->getQuantity();

        if ($request->getAvailableStock() < $quantity) {
            return $this->validationError(
                null,
                'Yeterli stok bulunmamaktadır.'
            );
        }

        $item = $this->cartService->add($product, $variation, $quantity);

        return $this->success([
            'cart_count'    => $this->cartService->getItemCount(),
            'cart_subtotal' => number_format(
                $this->cartService->getSubtotal(),
                2,
                ',',
                '.'
            ),
            'item' => CartItemResource::make($item),
        ], 'Ürün sepete eklendi.');
    }

    public function update(
        UpdateCartItemRequest $request,
        int $itemId
    ): JsonResponse {
        $cart = $this->cartService->getCart();
        $item = $cart->items()->findOrFail($itemId);

        $quantity = $request->getQuantity();

        if ($quantity <= 0) {
            $this->cartService->remove($item);
            $message = 'Ürün sepetten kaldırıldı.';
        } else {
            $availableStock = $item->variation
                ? $item->variation->stock_quantity
                : ($item->product->stock_quantity ?? 0);

            if ($availableStock < $quantity) {
                return $this->validationError(
                    null,
                    'Yeterli stok bulunmamaktadır.'
                );
            }

            $item = $this->cartService->update($item, $quantity);
            $message = 'Sepet güncellendi.';
        }

        $cart->refresh();

        return $this->success([
            'cart_count'    => $cart->item_count,
            'cart_subtotal' => number_format($cart->subtotal, 2, ',', '.'),
            'item_total'    => $quantity > 0
                ? number_format($item->total, 2, ',', '.')
                : null,
        ], $message);
    }

    public function destroy(int $itemId): JsonResponse
    {
        $cart = $this->cartService->getCart();
        $item = $cart->items()->findOrFail($itemId);

        $this->cartService->remove($item);
        $cart->refresh();

        return $this->success([
            'cart_count'    => $cart->item_count,
            'cart_subtotal' => number_format($cart->subtotal, 2, ',', '.'),
        ], 'Ürün sepetten kaldırıldı.');
    }

    public function destroyAll(): RedirectResponse
    {
        $this->cartService->clear();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Sepet temizlendi.');
    }
}
