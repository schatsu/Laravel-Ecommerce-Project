@extends('app.layouts.main')
@section('title', 'Sepetim')

@push('css')
<style>
    .cart-page-container {
        padding: 40px 0 80px;
    }

    .cart-header {
        margin-bottom: 30px;
    }

    .cart-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .cart-header .cart-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #1a1a1a;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        margin-left: 10px;
    }

    /* Cart Card */
    .cart-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
    }

    .cart-card-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cart-card-header h6 {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-card-header svg {
        width: 20px;
        height: 20px;
    }

    .cart-card-body {
        padding: 0;
    }

    /* Cart Item */
    .cart-item {
        display: flex;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
        transition: background 0.2s ease;
    }

    .cart-item:hover {
        background: #fafafa;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item-image {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        background: #f5f5f5;
        flex-shrink: 0;
        border: 1px solid #eee;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .cart-item-details {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 6px;
        text-decoration: none;
        display: block;
    }

    .cart-item-name:hover {
        color: #666;
    }

    .cart-item-variant {
        font-size: 13px;
        color: #888;
        margin-bottom: 10px;
    }

    .cart-item-remove {
        font-size: 12px;
        color: #dc2626;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s ease;
    }

    .cart-item-remove:hover {
        color: #b91c1c;
    }

    .cart-item-price {
        text-align: center;
        min-width: 100px;
    }

    .cart-item-price .label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .cart-item-price .value {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .cart-item-quantity {
        min-width: 120px;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        overflow: hidden;
    }

    .quantity-selector button {
        width: 40px;
        height: 40px;
        border: none;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .quantity-selector button:hover {
        background: #f5f5f5;
    }

    .quantity-selector button svg {
        width: 12px;
        height: 12px;
    }

    .quantity-selector input {
        width: 50px;
        height: 40px;
        border: none;
        border-left: 1px solid #e8e8e8;
        border-right: 1px solid #e8e8e8;
        text-align: center;
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
        background: transparent;
    }

    .cart-item-total {
        text-align: right;
        min-width: 120px;
    }

    .cart-item-total .label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .cart-item-total .value {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Free Shipping Progress */
    .shipping-progress-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }

    .shipping-progress-bar {
        height: 8px;
        background: #e8e8e8;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .shipping-progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        border-radius: 4px;
        transition: width 0.3s ease;
        position: relative;
    }

    .shipping-progress-fill::after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        background: #1a1a1a;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .shipping-progress-text {
        font-size: 13px;
        color: #666;
    }

    .shipping-progress-text .highlight {
        font-weight: 700;
        color: #363636ff;
    }

    .shipping-success {
        color: #059669 !important;
    }

    /* Summary Card */
    .summary-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .summary-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        padding: 16px 20px;
    }

    .summary-header h6 {
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        margin: 0;
    }

    .summary-body {
        padding: 20px;
    }

    /* Coupon Section */
    .coupon-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px dashed #e8e8e8;
    }

    .coupon-input-group {
        display: flex;
        gap: 8px;
    }

    .coupon-input-group input {
        flex: 1;
        padding: 12px 14px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        font-size: 14px;
        transition: border-color 0.2s ease;
    }

    .coupon-input-group input:focus {
        outline: none;
        border-color: #1a1a1a;
    }

    .coupon-input-group button {
        padding: 12px 20px;
        background: #1a1a1a;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .coupon-input-group button:hover {
        background: #333;
    }

    .coupon-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 8px;
    }

    .applied-coupon {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 10px;
    }

    .applied-coupon-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .applied-coupon-info svg {
        width: 18px;
        height: 18px;
        color: #059669;
    }

    .applied-coupon-code {
        font-weight: 700;
        color: #059669;
    }

    .applied-coupon-value {
        font-size: 12px;
        color: #666;
    }

    .remove-coupon-btn {
        color: #dc2626;
        font-size: 18px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
    }

    /* Price Rows */
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .price-row .label {
        font-size: 14px;
        color: #666;
    }

    .price-row .value {
        font-size: 14px;
        font-weight: 500;
        color: #1a1a1a;
    }

    .price-row.discount .value {
        color: #059669;
    }

    .price-row.total {
        border-top: 2px solid #1a1a1a;
        margin-top: 12px;
        padding-top: 14px;
    }

    .price-row.total .label,
    .price-row.total .value {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Checkout Button */
    .btn-checkout {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        margin-top: 20px;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        color: #fff;
    }

    .shipping-note {
        text-align: center;
        font-size: 12px;
        color: #888;
        margin-top: 14px;
    }

    /* Payment Trust */
    .payment-trust {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #eee;
        margin-top: 20px;
    }

    .payment-trust-title {
        font-size: 12px;
        font-weight: 600;
        color: #888;
        margin-bottom: 10px;
    }

    .payment-trust img {
        max-height: 30px;
        opacity: 0.7;
    }

    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-cart-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        background: #f5f5f5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-cart-icon svg {
        width: 40px;
        height: 40px;
        color: #ccc;
    }

    .empty-cart h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .empty-cart p {
        font-size: 14px;
        color: #888;
        margin-bottom: 24px;
    }

    .btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #fff;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .cart-item {
            flex-wrap: wrap;
        }

        .cart-item-price,
        .cart-item-quantity,
        .cart-item-total {
            min-width: auto;
        }

        .cart-item-details {
            width: calc(100% - 120px);
        }

        .cart-item-price,
        .cart-item-quantity,
        .cart-item-total {
            width: 33.33%;
            margin-top: 15px;
        }

        .cart-item-price,
        .cart-item-quantity {
            text-align: left;
        }
    }

    @media (max-width: 576px) {
        .cart-item-image {
            width: 80px;
            height: 80px;
        }

        .cart-item-price,
        .cart-item-quantity,
        .cart-item-total {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #eee;
        }

        .cart-item-price .label,
        .cart-item-quantity .label,
        .cart-item-total .label {
            display: block;
        }

        .quantity-selector {
            width: auto;
        }
    }
</style>
@endpush

@section('content')
    <x-page-title-component :name="'Sepetim'"/>

    <section class="cart-page-container">
        <div class="container">
            @if($cart->is_empty)
                <div class="cart-card">
                    <div class="empty-cart">
                        <div class="empty-cart-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <h3>Sepetiniz Boş</h3>
                        <p>Sepetinizde henüz ürün bulunmuyor. Alışverişe başlamak için aşağıdaki butona tıklayın.</p>
                        <a href="{{ route('category.index') }}" class="btn-shop">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            Alışverişe Başla
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <!-- Free Shipping Progress -->
                        <div class="shipping-progress-card">
                            <div class="shipping-progress-bar">
                                <div class="shipping-progress-fill" style="width: {{ $shippingProgress }}%;"></div>
                            </div>
                            <div class="shipping-progress-text">
                                @if($shippingRemaining > 0)
                                    Ücretsiz kargo için <span class="highlight">{{ number_format($shippingRemaining, 2, ',', '.') }} ₺</span> daha ekleyin
                                @else
                                    <span class="shipping-success">🎉 Ücretsiz Kargo Kazandınız!</span>
                                @endif
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="cart-card">
                            <div class="cart-card-header">
                                <h6>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    Sepetim ({{ $cart->items->count() }} Ürün)
                                </h6>
                            </div>
                            <div class="cart-card-body">
                                @foreach($cart->items as $item)
                                    <div class="cart-item" data-item-id="{{ $item->id }}">
                                        <a href="{{ route('product.show', $item->product->slug) }}" class="cart-item-image">
                                            <img src="{{ $item->image_url ?: asset('front/images/default.jpg') }}" alt="{{ $item->product->name }}">
                                        </a>
                                        <div class="cart-item-details">
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="cart-item-name">
                                                {{ $item->product->name }}
                                            </a>
                                            @if($item->variation)
                                                <div class="cart-item-variant">
                                                    @foreach($item->variation->selectedOptions() as $option)
                                                        {{ $option->name }}@if(!$loop->last) / @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            <span class="cart-item-remove remove-cart" data-item-id="{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Kaldır
                                            </span>
                                        </div>
                                        <div class="cart-item-price">
                                            <div class="label">Fiyat</div>
                                            <div class="value">{{ number_format($item->unit_price, 2, ',', '.') }} ₺</div>
                                        </div>
                                        <div class="cart-item-quantity">
                                            <div class="quantity-selector">
                                                <button type="button" class="btndecrease" data-item-id="{{ $item->id }}">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M5 12h14"/>
                                                    </svg>
                                                </button>
                                                <input type="text" value="{{ $item->quantity }}" class="quantity-input" readonly>
                                                <button type="button" class="btnincrease" data-item-id="{{ $item->id }}">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M12 5v14M5 12h14"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="cart-item-total">
                                            <div class="label">Toplam</div>
                                            <div class="value item-total">{{ number_format($item->total, 2, ',', '.') }} ₺</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="summary-card">
                            <div class="summary-header">
                                <h6>Sipariş Özeti</h6>
                            </div>
                            <div class="summary-body">
                                <!-- Coupon Section -->
                                <div class="coupon-section">
                                    <div id="coupon-form-container" @if($cart->coupon) style="display:none;" @endif>
                                        <div class="coupon-input-group">
                                            <input type="text" id="coupon-code-input" placeholder="Kupon kodu">
                                            <button type="button" id="apply-coupon-btn">Uygula</button>
                                        </div>
                                        <div id="coupon-error" class="coupon-error" style="display:none;"></div>
                                    </div>

                                    <div id="applied-coupon-container" @if(!$cart->coupon) style="display:none;" @endif>
                                        <div class="applied-coupon">
                                            <div class="applied-coupon-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>
                                                    <span class="applied-coupon-code" id="applied-coupon-code">{{ $cart->coupon?->code }}</span>
                                                    <span class="applied-coupon-value" id="applied-coupon-value">({{ $cart->coupon?->formatted_value }})</span>
                                                </span>
                                            </div>
                                            <button type="button" class="remove-coupon-btn" id="remove-coupon-btn">×</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="price-row">
                                    <span class="label">Ara Toplam</span>
                                    <span class="value cart-subtotal-value">{{ number_format($cart->subtotal, 2, ',', '.') }} ₺</span>
                                </div>

                                <div class="price-row discount discount-row" @if(!$cart->coupon) style="display:none;" @endif>
                                    <span class="label">İndirim</span>
                                    <span class="value discount-value">-{{ number_format($cart->discount_amount, 2, ',', '.') }} ₺</span>
                                </div>

                                <div class="price-row total">
                                    <span class="label">Toplam</span>
                                    <span class="value cart-total-value">{{ number_format($cart->total, 2, ',', '.') }} ₺</span>
                                </div>

                                <a href="{{ route('checkout.index') }}" class="btn-checkout">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    Ödemeye Geç
                                </a>

                                <p class="shipping-note">Kargo ücreti ödeme sayfasında hesaplanacaktır</p>

                                <div class="payment-trust">
                                    <div class="payment-trust-title">Güvenli Ödeme</div>
                                    <img src="{{ asset('front/images/brand/logo_band_colored.svg') }}" alt="Payment Methods">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
$(document).ready(() => {
    const FREE_SHIPPING_THRESHOLD = 450000;
    const rowLocks = new Set();

    axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
    axios.defaults.headers.common['Accept'] = 'application/json';

    const normalizePrice = (price) => {
        if (typeof price === 'number') return price;
        return parseFloat(price.replace(/\./g, '').replace(',', '.').replace('₺', '').trim());
    };

    const formatPrice = (price) =>
        normalizePrice(price).toLocaleString('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' ₺';

    const updateSubtotal = (subtotal) => {
        $('.cart-subtotal-value').text(formatPrice(subtotal));
    };

    const updateTotal = (total) => {
        $('.cart-total-value').text(formatPrice(total));
    };

    const updateCartCount = (count) => {
        $('.count-box, .cart-count, .toolbar-count').text(count);
        $('.cart-card-header h6').html(`
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
            Sepetim (${count} Ürün)
        `);
    };

    const updateShippingProgress = (subtotal) => {
        const subtotalNum = normalizePrice(subtotal);
        const progress = Math.min((subtotalNum / FREE_SHIPPING_THRESHOLD) * 100, 100);

        $('.shipping-progress-fill').css('width', `${progress}%`);

        const $text = $('.shipping-progress-text');
        if (subtotalNum >= FREE_SHIPPING_THRESHOLD) {
            $text.html('<span class="shipping-success">🎉 Ücretsiz Kargo Kazandınız!</span>');
        } else {
            const remaining = FREE_SHIPPING_THRESHOLD - subtotalNum;
            $text.html(`Ücretsiz kargo için <span class="highlight">${formatPrice(remaining)}</span> daha ekleyin`);
        }
    };

    const toast = (message, type = 'success') => {
        if (window.showToast) {
            window.showToast(message, type);
        }
    };

    const updateCartItem = async (itemId, quantity, $row) => {
        if (rowLocks.has(itemId)) return;
        rowLocks.add(itemId);

        try {
            const url = '{{ route("cart.update", ["item" => "__ITEM_ID__"]) }}'.replace('__ITEM_ID__', itemId);
            const response = await axios.patch(url, { quantity });

            if (!response.data.success) {
                toast(response.data.message || 'Bir hata oluştu', 'error');
                return;
            }

            $row.find('.quantity-input').val(quantity);
            $row.find('.item-total').text(formatPrice(response.data.data.item_total));

            updateSubtotal(response.data.data.cart_subtotal);
            updateTotal(response.data.data.cart_total || response.data.data.cart_subtotal);
            updateCartCount(response.data.data.cart_count);
            updateShippingProgress(response.data.data.cart_subtotal);

        } catch (error) {
            console.error(error);
            toast(error.response?.data?.message || 'Bir hata oluştu', 'error');
        } finally {
            rowLocks.delete(itemId);
        }
    };

    const removeCartItem = async (itemId, $row) => {
        try {
            const url = '{{ route("cart.destroy", ["item" => "__ITEM_ID__"]) }}'.replace('__ITEM_ID__', itemId);
            const response = await axios.delete(url);

            if (!response.data.success) {
                toast(response.data.message || 'Bir hata oluştu', 'error');
                return;
            }

            const resData = response.data.data;

            $row.fadeOut(250, () => {
                $row.remove();
                if (resData.cart_count === 0) location.reload();
            });

            updateSubtotal(resData.cart_subtotal);
            updateTotal(resData.cart_total || resData.cart_subtotal);
            updateCartCount(resData.cart_count);
            updateShippingProgress(resData.cart_subtotal);

            toast(response.data.message || 'Ürün sepetten kaldırıldı', 'success');

        } catch (error) {
            console.error(error);
            toast(error.response?.data?.message || 'Bir hata oluştu', 'error');
        }
    };

    $(document).on('click', '.remove-cart', function (e) {
        e.preventDefault();
        const $row = $(this).closest('.cart-item');
        const itemId = $(this).data('item-id');
        if (confirm('Bu ürünü sepetten kaldırmak istediğinize emin misiniz?')) {
            removeCartItem(itemId, $row);
        }
    });

    $(document).on('click', '.btnincrease', function () {
        const $row = $(this).closest('.cart-item');
        const itemId = $(this).data('item-id');
        const qty = parseInt($row.find('.quantity-input').val(), 10) || 1;
        updateCartItem(itemId, qty + 1, $row);
    });

    $(document).on('click', '.btndecrease', function () {
        const $row = $(this).closest('.cart-item');
        const itemId = $(this).data('item-id');
        const qty = parseInt($row.find('.quantity-input').val(), 10) || 1;
        if (qty > 1) updateCartItem(itemId, qty - 1, $row);
    });

    // ========== COUPON ==========

    const updateTotals = (subtotal, discount, total) => {
        updateSubtotal(subtotal);
        $('.discount-value').text('-' + formatPrice(discount));
        updateTotal(total);
        updateShippingProgress(subtotal);
    };

    const showCouponError = (message) => {
        $('#coupon-error').text(message).show();
    };

    const hideCouponError = () => {
        $('#coupon-error').hide();
    };

    const showAppliedCoupon = (coupon, discount) => {
        $('#applied-coupon-code').text(coupon.code);
        $('#applied-coupon-value').text('(' + coupon.formatted_value + ')');
        $('#coupon-form-container').hide();
        $('#applied-coupon-container').show();
        $('.discount-row').show();
        hideCouponError();
    };

    const hideCoupon = () => {
        $('#coupon-code-input').val('');
        $('#coupon-form-container').show();
        $('#applied-coupon-container').hide();
        $('.discount-row').hide();
    };

    $('#apply-coupon-btn').on('click', async function() {
        const code = $('#coupon-code-input').val().trim();

        if (!code) {
            showCouponError('Lütfen kupon kodu girin.');
            return;
        }

        const $btn = $(this);
        const originalText = $btn.text();
        $btn.prop('disabled', true).text('...');
        hideCouponError();

        try {
            const response = await axios.post('{{ route("cart.coupon.apply") }}', { code });

            if (response.data.success) {
                const data = response.data.data;
                showAppliedCoupon(data.coupon, data.discount_raw);
                const currentSubtotal = normalizePrice($('.cart-subtotal-value').text());
                updateTotals(currentSubtotal, data.discount_raw, data.total_raw);
                toast(response.data.message, 'success');
            } else {
                showCouponError(response.data.message);
            }
        } catch (error) {
            const message = error.response?.data?.message || 'Kupon uygulanırken bir hata oluştu.';
            showCouponError(message);
        } finally {
            $btn.prop('disabled', false).text(originalText);
        }
    });

    $('#coupon-code-input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#apply-coupon-btn').click();
        }
    });

    $('#remove-coupon-btn').on('click', async function() {
        const $btn = $(this);
        $btn.prop('disabled', true);

        try {
            const response = await axios.delete('{{ route("cart.coupon.remove") }}');

            if (response.data.success) {
                hideCoupon();
                const data = response.data.data;
                const subtotal = normalizePrice(data.subtotal);
                updateTotals(subtotal, 0, subtotal);
                toast(response.data.message, 'success');
            }
        } catch (error) {
            toast('Kupon kaldırılırken bir hata oluştu.', 'error');
        } finally {
            $btn.prop('disabled', false);
        }
    });
});
</script>
@endpush
