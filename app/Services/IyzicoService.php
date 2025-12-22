<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;

class IyzicoService
{
    private Options $options;

    public function __construct()
    {
        $this->options = new Options();
        $this->options->setApiKey(config('iyzico.api_key'));
        $this->options->setSecretKey(config('iyzico.secret_key'));
        $this->options->setBaseUrl(config('iyzico.base_url'));
    }

    public function createCheckoutForm(Order $order, User $user, array $billingAddress): CheckoutFormInitialize
    {
        $request = new CreateCheckoutFormInitializeRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($order->iyzico_conversation_id);
        $request->setPrice($order->subtotal);
        $request->setPaidPrice($order->total);
        $request->setCurrency(Currency::TL);
        $request->setBasketId($order->order_number);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);
        $request->setCallbackUrl(url(config('iyzico.callback_url')));
        $request->setEnabledInstallments([1, 2, 3, 6, 9, 12]);

        // Buyer
        $buyer = new Buyer();
        $buyer->setId((string) $user->id);
        $buyer->setName($billingAddress['first_name'] ?? $user->name);
        $buyer->setSurname($billingAddress['last_name'] ?? '');
        $buyer->setGsmNumber($billingAddress['phone'] ?? '');
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber('11111111111'); // TC Kimlik numarası
        $buyer->setRegistrationAddress($billingAddress['address'] ?? '');
        $buyer->setIp(request()->ip());
        $buyer->setCity($billingAddress['city'] ?? 'Istanbul');
        $buyer->setCountry($billingAddress['country'] ?? 'Turkey');
        $buyer->setZipCode($billingAddress['zip_code'] ?? '34000');
        $request->setBuyer($buyer);

        // Billing Address
        $iyzicoAddress = new Address();
        $iyzicoAddress->setContactName(($billingAddress['first_name'] ?? '') . ' ' . ($billingAddress['last_name'] ?? ''));
        $iyzicoAddress->setCity($billingAddress['city'] ?? 'Istanbul');
        $iyzicoAddress->setCountry($billingAddress['country'] ?? 'Turkey');
        $iyzicoAddress->setAddress($billingAddress['address'] ?? '');
        $iyzicoAddress->setZipCode($billingAddress['zip_code'] ?? '34000');
        $request->setBillingAddress($iyzicoAddress);
        $request->setShippingAddress($iyzicoAddress);

        // Basket Items
        $basketItems = [];
        foreach ($order->items as $item) {
            $basketItem = new BasketItem();
            $basketItem->setId((string) $item->id);
            $basketItem->setName($item->name);
            $basketItem->setCategory1('Ürün');
            $basketItem->setItemType(BasketItemType::PHYSICAL);
            $basketItem->setPrice($item->total);
            $basketItems[] = $basketItem;
        }
        $request->setBasketItems($basketItems);

        return CheckoutFormInitialize::create($request, $this->options);
    }

    public function retrieveCheckoutForm(string $token): CheckoutForm
    {
        $request = new RetrieveCheckoutFormRequest();
        $request->setLocale(Locale::TR);
        $request->setToken($token);

        return CheckoutForm::retrieve($request, $this->options);
    }

    public function isPaymentSuccessful(CheckoutForm $result): bool
    {
        return $result->getStatus() === 'success' && $result->getPaymentStatus() === 'SUCCESS';
    }
}
