<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Currency;
use Iyzipay\Model\InstallmentInfo;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentCard;
use Iyzipay\Model\PaymentChannel;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Model\ThreedsInitialize;
use Iyzipay\Model\ThreedsPayment;
use Iyzipay\Options;
use Iyzipay\Request\CreatePaymentRequest;
use Iyzipay\Request\CreateThreedsPaymentRequest;
use Iyzipay\Request\RetrieveInstallmentInfoRequest;

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

    /**
     * Taksit bilgilerini getir (BIN bazlı)
     */
    public function getInstallmentInfo(string $binNumber, float $price): ?InstallmentInfo
    {
        $request = new RetrieveInstallmentInfoRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId(uniqid());
        $request->setBinNumber($binNumber);
        $request->setPrice($price);

        return InstallmentInfo::retrieve($request, $this->options);
    }

    /**
     * 3D Secure ödeme başlat
     */
    public function create3DSecurePayment(
        Order $order,
        User $user,
        array $cardData,
        array $billingAddress,
        array $shippingAddress,
        int $installment = 1
    ): ThreedsInitialize {
        $request = new CreatePaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($order->iyzico_conversation_id);
        $request->setPrice($order->subtotal);
        $request->setPaidPrice($order->total);
        $request->setCurrency(Currency::TL);
        $request->setInstallment($installment);
        $request->setBasketId($order->order_number);
        $request->setPaymentChannel(PaymentChannel::WEB);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('checkout.3d-callback'));

        // Payment Card
        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($cardData['holder_name']);
        $paymentCard->setCardNumber(str_replace(' ', '', $cardData['card_number']));
        $paymentCard->setExpireMonth($cardData['expire_month']);
        $paymentCard->setExpireYear($cardData['expire_year']);
        $paymentCard->setCvc($cardData['cvc']);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        // Buyer
        $buyer = new Buyer();
        $buyer->setId((string) $user->id);
        $buyer->setName($billingAddress['first_name']);
        $buyer->setSurname($billingAddress['last_name']);
        $buyer->setGsmNumber($billingAddress['phone'] ?? '');
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber($billingAddress['identity_number'] ?? '11111111111');
        $buyer->setRegistrationAddress($billingAddress['address']);
        $buyer->setIp(request()->ip());
        $buyer->setCity($billingAddress['city']);
        $buyer->setCountry($billingAddress['country']);
        $buyer->setZipCode($billingAddress['zip_code'] ?? '34000');
        $request->setBuyer($buyer);

        // Billing Address
        $iyzicoAddress = new Address();
        $iyzicoAddress->setContactName($billingAddress['first_name'] . ' ' . $billingAddress['last_name']);
        $iyzicoAddress->setCity($billingAddress['city']);
        $iyzicoAddress->setCountry($billingAddress['country']);
        $iyzicoAddress->setAddress($billingAddress['address']);
        $iyzicoAddress->setZipCode($billingAddress['zip_code'] ?? '34000');
        $request->setBillingAddress($iyzicoAddress);

        // Shipping Address
        $shippingAddr = new Address();
        $shippingAddr->setContactName($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']);
        $shippingAddr->setCity($shippingAddress['city']);
        $shippingAddr->setCountry($shippingAddress['country']);
        $shippingAddr->setAddress($shippingAddress['address']);
        $shippingAddr->setZipCode($shippingAddress['zip_code'] ?? '34000');
        $request->setShippingAddress($shippingAddr);

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


        if ($order->shipping_cost > 0) {
            $shippingItem = new BasketItem();
            $shippingItem->setId('shipping');
            $shippingItem->setName('Kargo');
            $shippingItem->setCategory1('Kargo');
            $shippingItem->setItemType(BasketItemType::VIRTUAL);
            $shippingItem->setPrice($order->shipping_cost);
            $basketItems[] = $shippingItem;
        }

        $request->setBasketItems($basketItems);

        return ThreedsInitialize::create($request, $this->options);
    }

    /**
     * 3D Secure olmadan doğrudan ödeme
     */
    public function createDirectPayment(
        Order $order,
        User $user,
        array $cardData,
        array $billingAddress,
        array $shippingAddress,
        int $installment = 1
    ): \Iyzipay\Model\Payment {
        $request = new CreatePaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($order->iyzico_conversation_id);
        $request->setPrice($order->subtotal);
        $request->setPaidPrice($order->total);
        $request->setCurrency(Currency::TL);
        $request->setInstallment($installment);
        $request->setBasketId($order->order_number);
        $request->setPaymentChannel(PaymentChannel::WEB);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);

        // Payment Card
        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($cardData['holder_name']);
        $paymentCard->setCardNumber(str_replace(' ', '', $cardData['card_number']));
        $paymentCard->setExpireMonth($cardData['expire_month']);
        $paymentCard->setExpireYear($cardData['expire_year']);
        $paymentCard->setCvc($cardData['cvc']);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        // Buyer
        $buyer = new Buyer();
        $buyer->setId((string) $user->id);
        $buyer->setName($billingAddress['first_name']);
        $buyer->setSurname($billingAddress['last_name']);
        $buyer->setGsmNumber($billingAddress['phone'] ?? '');
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber($billingAddress['identity_number'] ?? '11111111111');
        $buyer->setRegistrationAddress($billingAddress['address']);
        $buyer->setIp(request()->ip());
        $buyer->setCity($billingAddress['city']);
        $buyer->setCountry($billingAddress['country']);
        $buyer->setZipCode($billingAddress['zip_code'] ?? '34000');
        $request->setBuyer($buyer);

        // Billing Address
        $iyzicoAddress = new Address();
        $iyzicoAddress->setContactName($billingAddress['first_name'] . ' ' . $billingAddress['last_name']);
        $iyzicoAddress->setCity($billingAddress['city']);
        $iyzicoAddress->setCountry($billingAddress['country']);
        $iyzicoAddress->setAddress($billingAddress['address']);
        $iyzicoAddress->setZipCode($billingAddress['zip_code'] ?? '34000');
        $request->setBillingAddress($iyzicoAddress);

        // Shipping Address
        $shippingAddr = new Address();
        $shippingAddr->setContactName($shippingAddress['first_name'] . ' ' . $shippingAddress['last_name']);
        $shippingAddr->setCity($shippingAddress['city']);
        $shippingAddr->setCountry($shippingAddress['country']);
        $shippingAddr->setAddress($shippingAddress['address']);
        $shippingAddr->setZipCode($shippingAddress['zip_code'] ?? '34000');
        $request->setShippingAddress($shippingAddr);

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

        if ($order->shipping_cost > 0) {
            $shippingItem = new BasketItem();
            $shippingItem->setId('shipping');
            $shippingItem->setName('Kargo');
            $shippingItem->setCategory1('Kargo');
            $shippingItem->setItemType(BasketItemType::VIRTUAL);
            $shippingItem->setPrice($order->shipping_cost);
            $basketItems[] = $shippingItem;
        }

        $request->setBasketItems($basketItems);

        return \Iyzipay\Model\Payment::create($request, $this->options);
    }


    public function complete3DSecurePayment(string $paymentId): ThreedsPayment
    {
        $request = new CreateThreedsPaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId(uniqid());
        $request->setPaymentId($paymentId);

        return ThreedsPayment::create($request, $this->options);
    }


    public function isPaymentSuccessful($result): bool
    {
        if ($result->getStatus() !== 'success') {
            return false;
        }


        if ($result->getErrorCode() !== null) {
            return false;
        }

        $paymentStatus = $result->getPaymentStatus();
        return $paymentStatus === null || $paymentStatus === 'SUCCESS';
    }
}
