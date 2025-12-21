<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\Responder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use Responder;

    public function toggle(string $slug): JsonResponse
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        $user->toggleFavorite($product);

        $isFavorited = $user->hasFavorited($product);
        $favoritesCount = $user->favorites(Product::class)->count();

        return $this->success(
            [
                'is_favorited' => $isFavorited,
                'favorites_count' => $favoritesCount
            ],
            $isFavorited ? 'Ürün favorilere eklendi' : 'Ürün favorilerden çıkarıldı'
        );
    }


    public function index()
    {
        $favorites = auth()->user()
            ->favorites(Product::class)
            ->with('media')
            ->paginate();

        return view('app.favorites.index', compact('favorites'));
    }
}
