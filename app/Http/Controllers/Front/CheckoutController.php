<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CheckoutProcessRequest;
use App\Models\Country;
use App\Models\Order;
use App\Models\VariationTypeOption;
use App\Services\CartService;
use App\Services\IyzicoService;
use App\Services\OrderService;
use App\Traits\Responder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    use Responder;

    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
        private readonly IyzicoService $iyzicoService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.product.media', 'items.variation');

        if ($cart->is_empty) {
            return redirect()->route('home')->with('toast_error', 'Sepetiniz boş.');
        }

        $this->preloadVariationOptions($cart->items);

        $user = auth()->user();
        $addresses = $user->invoices;
        $defaultAddress = $addresses->firstWhere('default_invoice', true) ?? $addresses->first();

        $countries = Country::query()
            ->select(['id', 'slug', 'name'])
            ->orderByRaw("CASE WHEN (name = 'Türkiye') THEN 1 ELSE 0 END DESC")
            ->get();

        return view('app.checkout.index', compact('cart', 'addresses', 'defaultAddress', 'countries'));
    }

    public function process(CheckoutProcessRequest $request)
    {

        $cart = $this->cartService->getCart();
        $cart->load('items.product', 'items.variation');

        if ($cart->is_empty) {
            return redirect()->route('home')->with('toast_error', 'Sepetiniz boş.');
        }

        $user = auth()->user();
        $address = $user->invoices()->findOrFail($request->address_id);

        $billingAddress = [
            'first_name' => $address->name,
            'last_name' => $address->surname ?? $address->name,
            'phone' => $address->phone,
            'address' => $address->address,
            'city' => $address->city?->name ?? 'Istanbul',
            'district' => $address->district?->name ?? '',
            'country' => $address->country?->name ?? 'Turkey',
            'zip_code' => $address->zip_code ?? '34000',
        ];

        $shippingCost = $cart->subtotal >= 500 ? 0 : 29.90;

        $order = $this->orderService->createFromCart($cart, $billingAddress, null, $shippingCost);

        $checkoutForm = $this->iyzicoService->createCheckoutForm($order, $user, $billingAddress);

        if ($checkoutForm->getStatus() !== 'success') {
            $this->orderService->markAsFailed($order);
            return redirect()->route('checkout.fail')->with('error', $checkoutForm->getErrorMessage());
        }

        $order->update(['iyzico_payment_id' => $checkoutForm->getToken()]);

        return view('app.checkout.payment', [
            'checkoutFormContent' => $checkoutForm->getCheckoutFormContent(),
            'order' => $order,
        ]);
    }

    public function callback(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return redirect()->route('checkout.fail')->with('error', 'Geçersiz ödeme token.');
        }

        $result = $this->iyzicoService->retrieveCheckoutForm($token);

        $order = Order::query()->where('iyzico_payment_id', $token)->first();

        if (!$order) {
            return redirect()->route('checkout.fail')->with('error', 'Sipariş bulunamadı.');
        }

        if ($this->iyzicoService->isPaymentSuccessful($result)) {
            $this->orderService->markAsPaid($order, $result->getPaymentId());
            return redirect()->route('checkout.success', $order->hashid());
        }

        $this->orderService->markAsFailed($order);
        return redirect()->route('checkout.fail')->with('error', $result->getErrorMessage() ?? 'Ödeme başarısız.');
    }

    public function success(string $hashId): View
    {
        $order = Order::query()
            ->whereRelation('user', 'id', auth()->id())
            ->findByHashidOrFail($hashId);

        $order->load(['items.product.media', 'items.variation']);

        $this->preloadVariationOptions($order->items);

        return view('app.checkout.success', compact('order'));
    }

    public function fail(): View
    {
        return view('app.checkout.fail');
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
