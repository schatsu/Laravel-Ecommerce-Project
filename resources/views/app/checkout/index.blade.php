@extends('app.layouts.main')
@section('title', 'Ödeme')
@push('css')
<style>
    /* Checkout Container */
    .checkout-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Section Card */
    .checkout-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .checkout-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }

    .checkout-card-header {
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        padding: 16px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .checkout-card-header h5 {
        font-weight: 700;
        font-size: 16px;
        color: #1a1a1a;
        margin: 0;
    }

    .checkout-card-body {
        padding: 20px;
    }

    /* Address Cards */
    .address-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .address-card {
        background: #fff;
        border: 2px solid #e8e8e8;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .address-card:hover {
        border-color: #999;
        background: #fafafa;
    }

    .address-card.selected {
        border-color: #1a1a1a;
        background: #fafafa;
    }

    .address-card label {
        cursor: pointer;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        width: 100%;
    }

    .address-card input[type="radio"] {
        margin-top: 2px;
        accent-color: #1a1a1a;
    }

    .address-info {
        flex: 1;
    }

    .address-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .address-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
    }

    .badge-default {
        font-size: 10px;
        font-weight: 700;
        padding: 4px 8px;
        background: #1a1a1a;
        color: #fff;
        border-radius: 4px;
        letter-spacing: 0.5px;
    }

    .address-text {
        font-size: 13px;
        color: #666;
        margin-bottom: 6px;
        line-height: 1.5;
    }

    .address-phone {
        font-size: 12px;
        color: #888;
    }

    .btn-add-address {
        background: transparent;
        border: 2px dashed #ccc;
        border-radius: 12px;
        padding: 14px 20px;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        width: 100%;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-address:hover {
        border-color: #1a1a1a;
        color: #1a1a1a;
        background: #fafafa;
    }

    .empty-address-box {
        padding: 24px;
        background: #f9f9f9;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 12px;
    }

    .empty-address-box p {
        color: #888;
        margin: 0;
    }

    /* Checkbox */
    .form-check-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: #f9f9f9;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .form-check-custom:hover {
        background: #f0f0f0;
    }

    .form-check-custom input {
        accent-color: #1a1a1a;
    }

    .form-check-custom label {
        cursor: pointer;
        font-size: 14px;
        color: #333;
    }

    /* Order Summary */
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
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .summary-header .step-number {
        background: #fff;
        color: #1a1a1a;
    }

    .summary-header h5 {
        font-weight: 700;
        font-size: 16px;
        color: #fff;
        margin: 0;
    }

    .summary-body {
        padding: 20px;
    }

    /* Cart Items */
    .cart-items-list {
        max-height: 280px;
        overflow-y: auto;
        margin-bottom: 20px;
        padding-right: 8px;
    }

    .cart-items-list::-webkit-scrollbar {
        width: 4px;
    }

    .cart-items-list::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 4px;
    }

    .cart-items-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .cart-item {
        display: flex;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #eee;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: contain;
        background: #f8f8f8;
        padding: 4px;
        border: 1px solid #eee;
    }

    .cart-item-details {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-weight: 600;
        font-size: 13px;
        color: #1a1a1a;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .cart-item-variant {
        font-size: 11px;
        color: #888;
        margin-bottom: 2px;
    }

    .cart-item-qty {
        font-size: 12px;
        color: #666;
    }

    .cart-item-price {
        font-weight: 700;
        font-size: 14px;
        color: #1a1a1a;
        white-space: nowrap;
    }

    /* Price Breakdown */
    .price-breakdown {
        border-top: 1px solid #eee;
        padding-top: 16px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
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
        border-top: 2px solid #eee;
        margin-top: 12px;
        padding-top: 16px;
    }

    .price-row.total .label,
    .price-row.total .value {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Coupon Box */
    .coupon-applied {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
        border-radius: 10px;
        margin-top: 16px;
    }

    .coupon-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .coupon-code {
        font-weight: 700;
        font-size: 14px;
        color: #1a1a1a;
    }

    .coupon-label {
        font-size: 12px;
        color: #888;
    }

    .coupon-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        background: #1a1a1a;
        color: #fff;
        border-radius: 4px;
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
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-checkout:disabled {
        background: #999;
        cursor: not-allowed;
    }

    .secure-badge {
        text-align: center;
        margin-top: 12px;
        font-size: 12px;
        color: #888;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .secure-badge i {
        color: #059669;
    }

    /* Modal Styles */
    #addressModal .modal-content {
        border-radius: 16px;
        overflow: hidden;
    }

    #addressModal .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #eee;
        background: #fafafa;
    }

    #addressModal .modal-title {
        font-size: 16px;
        font-weight: 700;
    }

    #addressModal .modal-body {
        padding: 20px;
    }

    #addressModal fieldset {
        border: none;
        padding: 0;
        margin: 0;
    }

    #addressModal fieldset label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #555;
        margin-bottom: 6px;
    }

    #addressModal fieldset input,
    #addressModal fieldset textarea,
    #addressModal fieldset select {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        font-size: 14px;
        transition: border-color 0.2s;
        background-color: #fff;
    }

    #addressModal fieldset input:focus,
    #addressModal fieldset select:focus,
    #addressModal fieldset textarea:focus {
        outline: none;
        border-color: #1a1a1a;
    }

    #addressModal .modal-footer {
        border-top: 1px solid #eee;
        padding: 16px 20px;
        background: #fafafa;
    }

    @media (max-width: 992px) {
        .summary-card {
            position: relative;
            top: 0;
        }
    }
</style>
@endpush
@section('content')
    <x-page-title-component :name="'Ödeme'"/>

    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                {{-- Sol Kolon - Adresler --}}
                <div class="col-lg-7 mb-4">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="checkout-container">
                            {{-- Teslimat Adresi --}}
                            <div class="checkout-card">
                                <div class="checkout-card-header">
                                    <span class="step-number">1</span>
                                    <h5>Teslimat Adresi</h5>
                                </div>
                                <div class="checkout-card-body">
                                    @if($addresses->count() > 0)
                                        <div class="address-list" id="delivery-address-list">
                                            @foreach($addresses as $address)
                                                <div class="address-card {{ $defaultAddress && $defaultAddress->id === $address->id ? 'selected' : '' }}">
                                                    <label>
                                                        <input type="radio"
                                                               name="delivery_address_id"
                                                               value="{{ $address->id }}"
                                                               {{ $defaultAddress && $defaultAddress->id === $address->id ? 'checked' : '' }}>
                                                        <div class="address-info">
                                                            <div class="address-header">
                                                                <span class="address-name">{{ $address->full_name }}</span>
                                                                @if($address->default_delivery)
                                                                    <span class="badge-default">VARSAYILAN</span>
                                                                @endif
                                                            </div>
                                                            <p class="address-text">{{ $address->full_address }}</p>
                                                            <span class="address-phone"><i class="icon-phone me-1"></i>{{ $address->phone }}</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="empty-address-box">
                                            <p>Kayıtlı teslimat adresiniz bulunmuyor.</p>
                                        </div>
                                    @endif

                                    <button type="button" class="btn-add-address mt-3" data-bs-toggle="modal" data-bs-target="#addressModal" data-type="delivery">
                                        <i class="icon-plus"></i>
                                        Yeni Teslimat Adresi Ekle
                                    </button>
                                </div>
                            </div>

                            {{-- Fatura Adresi --}}
                            <div class="checkout-card">
                                <div class="checkout-card-header">
                                    <span class="step-number">2</span>
                                    <h5>Fatura Adresi</h5>
                                </div>
                                <div class="checkout-card-body">
                                    <div class="form-check-custom mb-3">
                                        <input type="checkbox" id="same-as-delivery" name="same_as_delivery" checked>
                                        <label for="same-as-delivery">Fatura adresim teslimat adresimle aynı</label>
                                    </div>

                                    <div id="billing-address-section" style="display: none;">
                                        @if($addresses->count() > 0)
                                            <div class="address-list" id="billing-address-list">
                                                @foreach($addresses as $address)
                                                    <div class="address-card">
                                                        <label>
                                                            <input type="radio"
                                                                   name="billing_address_id"
                                                                   value="{{ $address->id }}">
                                                            <div class="address-info">
                                                                <div class="address-header">
                                                                    <span class="address-name">{{ $address->full_name }}</span>
                                                                    @if($address->default_billing)
                                                                        <span class="badge-default">VARSAYILAN</span>
                                                                    @endif
                                                                </div>
                                                                <p class="address-text">{{ $address->full_address }}</p>
                                                                @if($address->company_name)
                                                                    <span class="address-phone"><i class="icon-shop me-1"></i>{{ $address->company_name }} - {{ $address->tax_number }}</span>
                                                                @elseif($address->identity_number)
                                                                    <span class="address-phone">T.C.: {{ $address->identity_number }}</span>
                                                                @endif
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="empty-address-box">
                                                <p>Kayıtlı fatura adresiniz bulunmuyor.</p>
                                            </div>
                                        @endif

                                        <button type="button" class="btn-add-address mt-3" data-bs-toggle="modal" data-bs-target="#addressModal" data-type="billing">
                                            <i class="icon-plus"></i>
                                            Yeni Fatura Adresi Ekle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="same_as_delivery_hidden" id="same-as-delivery-hidden" value="1">
                    </form>
                </div>

                {{-- Sağ Kolon - Sipariş Özeti --}}
                <div class="col-lg-5">
                    <div class="summary-card">
                        <div class="summary-header">
                            <span class="step-number">3</span>
                            <h5>Sipariş Özeti</h5>
                        </div>
                        <div class="summary-body">
                            {{-- Ürünler --}}
                            <div class="cart-items-list">
                                @foreach($cart->items as $item)
                                    <div class="cart-item">
                                        <img src="{{ $item->image_url }}"
                                             alt="{{ $item->product->name }}"
                                             class="cart-item-image">
                                        <div class="cart-item-details">
                                            <p class="cart-item-name">{{ Str::limit($item->product->name, 35) }}</p>
                                            @if($item->variation)
                                                <p class="cart-item-variant">
                                                    {{ $item->variation->selectedOptions()->pluck('name')->implode(' / ') }}
                                                </p>
                                            @endif
                                            <span class="cart-item-qty">{{ $item->quantity }} adet</span>
                                        </div>
                                        <span class="cart-item-price">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Fiyat Dökümü --}}
                            <div class="price-breakdown">
                                <div class="price-row">
                                    <span class="label">Ara Toplam</span>
                                    <span class="value">{{ number_format($cart->subtotal, 2, ',', '.') }} ₺</span>
                                </div>

                                @if($cart->coupon && $cart->discount_amount > 0)
                                    <div class="price-row discount">
                                        <span class="label">Kupon ({{ $cart->coupon->code }})</span>
                                        <span class="value">-{{ number_format($cart->discount_amount, 2, ',', '.') }} ₺</span>
                                    </div>
                                @endif

                                <div class="price-row">
                                    <span class="label">Kargo</span>
                                    <span class="value">{{ $shippingCost == 0 ? 'Ücretsiz' : number_format($shippingCost, 2, ',', '.') . ' ₺' }}</span>
                                </div>

                                <div class="price-row total">
                                    <span class="label">Toplam</span>
                                    <span class="value">{{ number_format($grandTotal, 2, ',', '.') }} ₺</span>
                                </div>
                            </div>

                            @if($cart->coupon)
                                <div class="coupon-applied">
                                    <div class="coupon-info">
                                        <span class="coupon-code">{{ $cart->coupon->code }}</span>
                                        <span class="coupon-label">uygulandı</span>
                                    </div>
                                    <span class="coupon-badge">{{ $cart->coupon->formatted_value }}</span>
                                </div>
                            @endif

                            <button type="submit"
                                    form="checkout-form"
                                    class="btn-checkout"
                                    {{ $addresses->count() === 0 ? 'disabled' : '' }}>
                                <i class="icon-lock"></i>
                                Güvenli Ödemeye Geç
                            </button>

                            <div class="secure-badge">
                                <i class="icon-check"></i>
                                256-bit SSL ile güvenli ödeme
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Adres Modal --}}
    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addressModalTitle">Yeni Adres Ekle</h6>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="modal-body">
                    <form id="address-form">
                        <input type="hidden" name="type" id="address-type" value="delivery">

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="mb-3">
                                    <label>Ad *</label>
                                    <input type="text" name="name" id="address-name" required>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="mb-3">
                                    <label>Soyad *</label>
                                    <input type="text" name="surname" id="address-surname" required>
                                </fieldset>
                            </div>
                        </div>

                        <fieldset class="mb-3">
                            <label>Telefon *</label>
                            <input type="text" name="phone" id="address-phone" required>
                        </fieldset>

                        <div class="row">
                            <div class="col-md-4">
                                <fieldset class="mb-3">
                                    <label>Ülke *</label>
                                    <select class="country-select" name="country" id="modal-country" required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->slug }}" {{ $country->name === 'Türkiye' ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="mb-3">
                                    <label>İl *</label>
                                    <select class="city-select" name="city" id="modal-city" required>
                                        <option value="" disabled selected>İl Seçiniz</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="mb-3">
                                    <label>İlçe *</label>
                                    <select class="district-select" name="district" id="modal-district" required>
                                        <option value="" disabled selected>İlçe Seçiniz</option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>

                        <fieldset class="mb-3">
                            <label>Açık Adres *</label>
                            <textarea name="address" id="address-detail" rows="2" required></textarea>
                        </fieldset>

                        {{-- Fatura Bilgileri --}}
                        <div id="billing-fields" style="display: none;">
                            <hr class="my-3">
                            <p class="fw-6 mb-3">Fatura Bilgileri</p>

                            <fieldset class="mb-3">
                                <label>Fatura Tipi</label>
                                <select class="company-type-select" name="company_type">
                                    <option value="individual" selected>Bireysel</option>
                                    <option value="corporate">Kurumsal</option>
                                </select>
                            </fieldset>

                            <div id="individual-fields">
                                <fieldset class="mb-3">
                                    <label>T.C. Kimlik No</label>
                                    <input type="text" name="identity_number" id="identity-number" maxlength="11">
                                </fieldset>
                            </div>

                            <div id="corporate-fields" style="display: none;">
                                <fieldset class="mb-3">
                                    <label>Şirket Adı</label>
                                    <input type="text" name="company_name" id="company-name">
                                </fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="mb-3">
                                            <label>Vergi No</label>
                                            <input type="text" name="tax_number" id="tax-number">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="mb-3">
                                            <label>Vergi Dairesi</label>
                                            <input type="text" name="tax_office" id="tax-office">
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger mt-3" id="address-error" style="display: none;"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="tf-btn btn-fill animate-hover-btn" id="save-address-btn">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.10.0/axios.min.js"></script>
<script>
$(document).ready(function() {
    $('#same-as-delivery').change(function() {
        if ($(this).is(':checked')) {
            $('#billing-address-section').slideUp();
            $('#same-as-delivery-hidden').val('1');
        } else {
            $('#billing-address-section').slideDown();
            $('#same-as-delivery-hidden').val('0');
        }
    });

    $('[data-bs-target="#addressModal"]').click(function() {
        const type = $(this).data('type');
        $('#address-type').val(type);

        if (type === 'billing') {
            $('#addressModalTitle').text('Yeni Fatura Adresi Ekle');
            $('#billing-fields').show();
        } else {
            $('#addressModalTitle').text('Yeni Teslimat Adresi Ekle');
            $('#billing-fields').hide();
        }

        $('#address-form')[0].reset();
        $('#address-error').hide();

        $('.company-type-select').val('individual');
        $('#individual-fields').show();
        $('#corporate-fields').hide();

        if ($('.country-select').val()) {
            $('.country-select').trigger('change');
        }
    });

    $(document).on('change', '.company-type-select', function() {
        if ($(this).val() === 'corporate') {
            $('#individual-fields').slideUp(200);
            $('#corporate-fields').slideDown(200);
        } else {
            $('#individual-fields').slideDown(200);
            $('#corporate-fields').slideUp(200);
        }
    });

    $(document).on('change', '.country-select', function() {
        const selectedSlug = $(this).val();
        const $citySelect = $('.city-select');
        const $districtSelect = $('.district-select');

        if (!selectedSlug) return;

        $citySelect.empty().append('<option disabled selected>Yükleniyor...</option>');
        $districtSelect.empty().append('<option disabled selected>İlçe Seçiniz</option>');

        let url = '{{ route("account.cities", ["countrySlug" => "%%slug%%"]) }}';
        url = url.replace("%%slug%%", encodeURIComponent(selectedSlug));

        axios.get(url)
            .then(function(response) {
                const data = response.data.data;
                $citySelect.empty().append('<option disabled selected>İl Seçiniz</option>');

                $.each(data, function(index, item) {
                    $citySelect.append($('<option>', {
                        value: item.slug,
                        text: item.name
                    }));
                });
            })
            .catch(function(error) {
                console.error('Şehirler yüklenirken hata oluştu:', error);
                $citySelect.empty().append('<option disabled selected>Hata oluştu</option>');
            });
    });

    $(document).on('change', '.city-select', function() {
        const selectedSlug = $(this).val();
        const $districtSelect = $('.district-select');

        if (!selectedSlug) return;

        $districtSelect.empty().append('<option disabled selected>Yükleniyor...</option>');

        let url = '{{ route("account.districts", ["citySlug" => "%%slug%%"]) }}';
        url = url.replace("%%slug%%", encodeURIComponent(selectedSlug));

        axios.get(url)
            .then(function(response) {
                const data = response.data.data;
                $districtSelect.empty().append('<option disabled selected>İlçe Seçiniz</option>');

                $.each(data, function(index, item) {
                    $districtSelect.append($('<option>', {
                        value: item.slug,
                        text: item.name
                    }));
                });
            })
            .catch(function(error) {
                console.error('İlçeler yüklenirken hata oluştu:', error);
                $districtSelect.empty().append('<option disabled selected>Hata oluştu</option>');
            });
    });

    if ($('.country-select').val()) {
        $('.country-select').trigger('change');
    }

    $('#addressModal').on('shown.bs.modal', function() {
        if ($('.country-select').val() && $('.city-select option').length <= 1) {
            $('.country-select').trigger('change');
        }
    });

    $('#save-address-btn').click(function() {
        const $btn = $(this);
        const $error = $('#address-error');
        const originalText = $btn.text();

        $btn.prop('disabled', true).text('Kaydediliyor...');
        $error.hide();

        const formData = $('#address-form').serializeArray();
        const data = {};
        formData.forEach(item => data[item.name] = item.value);

        axios.post('{{ route("account.address.storeAjax") }}', data)
            .then(function(response) {
                if (response.data.success) {
                    const type = data.type;
                    const listId = type === 'billing' ? '#billing-address-list' : '#delivery-address-list';

                    if ($(listId).length === 0) {
                        const $section = type === 'billing' ? $('#billing-address-section') : $('.checkout-card-body').first();
                        $section.find('.empty-address-box').remove();

                        const $listContainer = $('<div>').addClass('address-list').attr('id', listId.substring(1));
                        $section.prepend($listContainer);
                    }

                    const html = `
                        <div class="address-card selected">
                            <label>
                                <input type="radio" name="${type}_address_id" value="${response.data.data.id}" checked>
                                <div class="address-info">
                                    <div class="address-header">
                                        <span class="address-name">${response.data.data.full_name}</span>
                                    </div>
                                    <p class="address-text">${response.data.data.full_address}</p>
                                    <span class="address-phone"><i class="icon-phone me-1"></i>${response.data.data.phone}</span>
                                </div>
                            </label>
                        </div>
                    `;

                    $(`input[name="${type}_address_id"]`).prop('checked', false);
                    $(`input[name="${type}_address_id"]`).closest('.address-card').removeClass('selected');

                    $(listId).append(html);
                    $('#addressModal').modal('hide');
                    $('#address-form')[0].reset();

                    $('button[type="submit"]').prop('disabled', false);

                    if (typeof showToast === 'function') {
                        showToast('Adres başarıyla eklendi.', 'success');
                    }
                }
            })
            .catch(function(error) {
                let errorMessage = 'Bir hata oluştu.';

                if (error.response && error.response.data) {
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        const messages = Object.values(errors).flat().join('<br>');
                        errorMessage = messages;
                    } else if (error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }
                }

                $error.html(errorMessage).slideDown(200);
            })
            .finally(function() {
                $btn.prop('disabled', false).text(originalText);
            });
    });

    $(document).on('change', 'input[type="radio"]', function() {
        const name = $(this).attr('name');
        $(`input[name="${name}"]`).closest('.address-card').removeClass('selected');
        $(this).closest('.address-card').addClass('selected');
    });

    $('#addressModal').on('hidden.bs.modal', function() {
        $('#address-form')[0].reset();
        $('#address-error').hide();
    });
});
</script>
@endpush
