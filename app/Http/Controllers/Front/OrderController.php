<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\VariationTypeOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->with(['items.product.media', 'items.variation'])
            ->latest()
            ->paginate(6);

        $this->preloadVariationOptions($orders->getCollection()->flatMap->items);

        return view('app.account.orders.index', compact('orders'));
    }

    public function show(string $hashId): View
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Order $order */
        $order = Order::query()
            ->whereRelation('user', 'id', $user->id)
            ->findByHashidOrFail($hashId);

        $order->load(['items.product.media', 'items.variation']);

        $this->preloadVariationOptions($order->items);

        return view('app.account.orders.show', compact('order'));
    }

    private function preloadVariationOptions(Collection $items): void
    {
        $allOptionIds = $items->flatMap(
            fn($item) => $item->variation?->variation_type_option_ids ?? []
        )->unique()->values()->all();

        if (empty($allOptionIds)) {
            return;
        }

        $options = VariationTypeOption::with(['variationType', 'media'])
            ->whereIn('id', $allOptionIds)
            ->get()
            ->keyBy('id');

        foreach ($items as $item) {
            if ($item->variation) {
                $item->setRelation('preloadedOptions',
                    collect($item->variation->variation_type_option_ids ?? [])
                        ->map(fn($id) => $options->get($id))
                        ->filter()
                );
            }
        }
    }
}
