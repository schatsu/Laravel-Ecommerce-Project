<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CheckoutProcessRequest;
use App\Http\Requests\Front\PaymentRequest;
use App\Models\Country;
use App\Models\Order;
use App\Models\VariationTypeOption;
use App\Services\CartService;
use App\Services\IyzicoService;
use App\Services\OrderService;
use App\Traits\Responder;
use Illuminate\Http\JsonResponse;
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
        $cart->load('items.product.media', 'items.variation', 'coupon');

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
        $cart->load('items.product', 'items.variation', 'coupon');

        if ($cart->is_empty) {
            return redirect()->route('home')->with('toast_error', 'Sepetiniz boş.');
        }

        $user = auth()->user();

        $deliveryAddress = $user->invoices()->findOrFail($request->delivery_address_id);

        $sameAsDelivery = $request->same_as_delivery_hidden === '1';
        $billingAddressModel = $sameAsDelivery
            ? $deliveryAddress
            : $user->invoices()->findOrFail($request->billing_address_id);

        $shippingAddress = $this->formatAddress($deliveryAddress);
        $billingAddress = $this->formatAddress($billingAddressModel);

        $shippingCost = $cart->subtotal >= 500 ? 0 : 29.90;

        $order = $this->orderService->createFromCart($cart, $billingAddress, $shippingAddress, $shippingCost);

        session([
            'checkout.billing_address' => $billingAddress,
            'checkout.shipping_address' => $shippingAddress,
        ]);

        return redirect()->route('checkout.payment-form', $order->hashid());
    }


    public function paymentForm(string $hashId): View
    {
        $order = Order::query()
            ->whereRelation('user', 'id', auth()->id())
            ->where('status', 'pending')
            ->findByHashidOrFail($hashId);

        $order->load('items.product.media');

        return view('app.checkout.payment-form', compact('order'));
    }


    public function getInstallments(string $bin, float $price): JsonResponse
    {
        $result = $this->iyzicoService->getInstallmentInfo($bin, $price);

        if ($result->getStatus() !== 'success') {
            return response()->json(['success' => false, 'installments' => []]);
        }

        $installments = [];
        $details = $result->getInstallmentDetails();

        if ($details && count($details) > 0) {
            foreach ($details[0]->getInstallmentPrices() as $inst) {
                $installments[] = [
                    'installment' => $inst->getInstallmentNumber(),
                    'total_price' => number_format($inst->getTotalPrice(), 2, ',', '.'),
                    'installment_price' => number_format($inst->getInstallmentPrice(), 2, ',', '.'),
                ];
            }
        }

        return response()->json(['success' => true, 'installments' => $installments]);
    }


    public function pay(PaymentRequest $request): View|RedirectResponse
    {
        $user = auth()->user();

        $order = Order::query()
            ->whereRelation('user', 'id', $user?->id)
            ->findOrFail($request->order_id);

        $expireParts = explode('/', $request->expire_date);
        $cardData = [
            'card_number' => $request->card_number,
            'holder_name' => $request->holder_name,
            'expire_month' => $expireParts[0] ?? '01',
            'expire_year' => '20' . ($expireParts[1] ?? '25'),
            'cvc' => $request->cvc,
        ];

        $billingAddress = session('checkout.billing_address', []);
        $shippingAddress = session('checkout.shipping_address', []);

        $use3DSecure = $request->has('use_3d_secure');

        if ($use3DSecure) {
            // 3D Secure ödeme
            $result = $this->iyzicoService->create3DSecurePayment(
                $order,
                $user,
                $cardData,
                $billingAddress,
                $shippingAddress,
                $request->installment ?? 1
            );

            if ($result->getStatus() !== 'success') {
                return redirect()->route('checkout.payment-form', $order->hashid())
                    ->with('error', $result->getErrorMessage() ?? 'Ödeme başlatılamadı.');
            }

            return view('app.checkout.3d-redirect', [
                'htmlContent' => $result->getHtmlContent(),
            ]);
        } else {
            // Doğrudan ödeme (3D'siz)
            $result = $this->iyzicoService->createDirectPayment(
                $order,
                $user,
                $cardData,
                $billingAddress,
                $shippingAddress,
                $request->installment ?? 1
            );

            \Log::info('Direct payment result', [
                'status' => $result->getStatus(),
                'paymentStatus' => $result->getPaymentStatus(),
                'errorCode' => $result->getErrorCode(),
                'errorMessage' => $result->getErrorMessage(),
            ]);

            if ($this->iyzicoService->isPaymentSuccessful($result)) {
                $this->orderService->markAsPaid($order, $result->getPaymentId());
                return redirect()->route('checkout.success', $order->hashid());
            }

            $this->orderService->markAsFailed($order);
            return redirect()->route('checkout.payment-form', $order->hashid())
                ->with('error', $result->getErrorMessage() ?? 'Ödeme başarısız.');
        }
    }


    public function threeDCallback(Request $request): RedirectResponse
    {
        $status = $request->input('status');
        $paymentId = $request->input('paymentId');
        $conversationId = $request->input('conversationId');
        $mdStatus = $request->input('mdStatus');

        // Debug log
        \Log::info('3D Callback received', [
            'status' => $status,
            'paymentId' => $paymentId,
            'conversationId' => $conversationId,
            'mdStatus' => $mdStatus,
            'all_data' => $request->all(),
        ]);

        $order = Order::query()->where('iyzico_conversation_id', $conversationId)->first();

        if (!$order) {
            \Log::error('Order not found for conversationId: ' . $conversationId);
            return redirect()->route('checkout.fail')->with('error', 'Sipariş bulunamadı.');
        }

        if ($status !== 'success' || !in_array($mdStatus, ['1', 1])) {
            \Log::warning('3D Secure failed', ['status' => $status, 'mdStatus' => $mdStatus]);
            $this->orderService->markAsFailed($order);
            return redirect()->route('checkout.fail')->with('error', '3D Secure doğrulaması başarısız.');
        }

        $result = $this->iyzicoService->complete3DSecurePayment($paymentId);

        // Debug log - iyzico result
        \Log::info('3D Payment completion result', [
            'status' => $result->getStatus(),
            'paymentStatus' => $result->getPaymentStatus(),
            'errorCode' => $result->getErrorCode(),
            'errorMessage' => $result->getErrorMessage(),
        ]);

        if ($this->iyzicoService->isPaymentSuccessful($result)) {
            $this->orderService->markAsPaid($order, $result->getPaymentId());
            return redirect()->route('checkout.success', $order->hashid());
        }

        $this->orderService->markAsFailed($order);
        return redirect()->route('checkout.fail')
            ->with('error', $result->getErrorMessage() ?? 'Ödeme tamamlanamadı.');
    }

    public function success(string $hashId): View
    {
        $order = Order::query()
            ->findByHashidOrFail($hashId);

        $order->load(['items.product.media', 'items.variation']);
        $this->preloadVariationOptions($order->items);

        return view('app.checkout.success', compact('order'));
    }

    public function fail(): View
    {
        return view('app.checkout.fail');
    }

    private function formatAddress($address): array
    {
        return [
            'first_name' => $address->name,
            'last_name' => $address->surname ?? $address->name,
            'phone' => $address->phone,
            'address' => $address->address,
            'city' => $address->city?->name ?? 'Istanbul',
            'district' => $address->district?->name ?? '',
            'country' => $address->country?->name ?? 'Turkey',
            'zip_code' => $address->zip_code ?? '34000',
            'identity_number' => $address->identity_number ?? '11111111111',
        ];
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
