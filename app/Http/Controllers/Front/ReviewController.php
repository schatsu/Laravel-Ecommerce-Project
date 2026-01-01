<?php

namespace App\Http\Controllers\Front;

use App\Enums\Admin\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Kullanıcı bu ürünü satın almış mı? (Teslim edilmiş siparişlerde)
        $hasPurchased = Order::where('user_id', auth()->id())
            ->where('status', OrderStatusEnum::DELIVERED)
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Yorum yapabilmek için bu ürünü satın almış olmalısınız.');
        }

        // Kullanıcı daha önce yorum yapmış mı?
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bu ürüne zaten yorum yapmışsınız.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Lütfen bir puan seçin.',
            'rating.min' => 'Puan en az 1 olmalıdır.',
            'rating.max' => 'Puan en fazla 5 olmalıdır.',
            'title.required' => 'Yorum başlığı zorunludur.',
            'title.max' => 'Yorum başlığı en fazla 255 karakter olabilir.',
            'content.required' => 'Yorum içeriği zorunludur.',
            'content.min' => 'Yorum en az 10 karakter olmalıdır.',
            'content.max' => 'Yorum en fazla 1000 karakter olabilir.',
        ]);

        // Sipariş ID'sini bul (isteğe bağlı)
        $order = Order::where('user_id', auth()->id())
            ->where('status', OrderStatusEnum::DELIVERED)
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->first();

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'order_id' => $order?->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Yorumunuz başarıyla gönderildi. Onaylandıktan sonra yayınlanacaktır.');
    }
}

