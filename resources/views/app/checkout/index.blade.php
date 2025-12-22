@extends('app.layouts.main')
@section('title', 'Ödeme')
@section('content')
    <x-page-title-component :name="'Ödeme'"/>

    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="tf-page-cart-wrap">
                        <h5 class="fw-5 mb_20">Teslimat Adresi</h5>

                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                            @csrf

                            @if($addresses->count() > 0)
                                <div class="address-list">
                                    @foreach($addresses as $address)
                                        <div class="address-item mb_15 p-3 border rounded {{ $defaultAddress && $defaultAddress->id === $address->id ? 'border-primary' : '' }}">
                                            <label class="d-flex align-items-start cursor-pointer">
                                                <input type="radio"
                                                       name="address_id"
                                                       value="{{ $address->id }}"
                                                       class="me-3 mt-1"
                                                       {{ $defaultAddress && $defaultAddress->id === $address->id ? 'checked' : '' }}>
                                                <div>
                                                    <strong>{{ $address->name }} {{ $address->surname }}</strong>
                                                    <p class="mb-1">{{ $address->address }}</p>
                                                    <small class="text-muted">
                                                        {{ $address->district?->name }}, {{ $address->city?->name }} / {{ $address->country?->name }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">Tel: {{ $address->phone }}</small>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <p>Kayıtlı adresiniz bulunmuyor.</p>
                                    <a href="{{ route('account.address') }}" class="btn btn-primary btn-sm mt-2">Adres Ekle</a>
                                </div>
                            @endif

                            <div class="mt_30">
                                <button type="submit"
                                        class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"
                                        {{ $addresses->count() === 0 ? 'disabled' : '' }}>
                                    <span>Ödemeye Geç</span>
                                    <i class="icon icon-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="tf-page-cart-footer">
                        <div class="tf-cart-footer-inner">
                            <h5 class="fw-5 mb_20">Sipariş Özeti</h5>

                            <div class="cart-items mb_20">
                                @foreach($cart->items as $item)
                                    <div class="d-flex align-items-center mb_15 pb_15 border-bottom">
                                        <img src="{{ $item->product->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png') }}"
                                             alt="{{ $item->product->name }}"
                                             class="me-3"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <p class="fw-5 mb-0">{{ $item->product->name }}</p>
                                            @if($item->variation)
                                                <small class="text-muted">
                                                    {{ $item->variation->selectedOptions()->pluck('name')->implode(', ') }}
                                                </small>
                                            @endif
                                            <div class="d-flex justify-content-between mt-1">
                                                <small>{{ $item->quantity }} adet</small>
                                                <strong>{{ number_format($item->total, 2, ',', '.') }} ₺</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mb_10">
                                <span>Ara Toplam</span>
                                <span class="fw-5">{{ number_format($cart->subtotal, 2, ',', '.') }} ₺</span>
                            </div>

                            <div class="d-flex justify-content-between mb_10">
                                <span>Kargo</span>
                                <span class="fw-5 {{ $cart->subtotal >= 500 ? 'text-success' : '' }}">
                                    {{ $cart->subtotal >= 500 ? 'Ücretsiz' : '29,90 ₺' }}
                                </span>
                            </div>

                            @if($cart->subtotal < 500)
                                <div class="alert alert-info mb_10" style="font-size: 12px;">
                                    <i class="icon-truck me-1"></i>
                                    500 ₺ üzeri siparişlerde kargo ücretsiz!
                                </div>
                            @endif

                            <hr>

                            <div class="d-flex justify-content-between">
                                <strong>Toplam</strong>
                                <strong class="text-primary" style="font-size: 1.25rem;">
                                    {{ number_format($cart->subtotal + ($cart->subtotal >= 500 ? 0 : 29.90), 2, ',', '.') }} ₺
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
