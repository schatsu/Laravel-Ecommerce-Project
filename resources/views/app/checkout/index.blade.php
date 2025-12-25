@extends('app.layouts.main')
@section('title', 'Ödeme')
@section('content')
    <x-page-title-component :name="'Ödeme'"/>

    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                {{-- Sol Kolon - Adresler --}}
                <div class="col-lg-7">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf

                        {{-- Teslimat Adresi --}}
                        <div class="checkout-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <span class="step-number me-3">1</span>
                                <h5 class="fw-bold mb-0">Teslimat Adresi</h5>
                            </div>

                            @if($addresses->count() > 0)
                                <div class="address-list" id="delivery-address-list">
                                    @foreach($addresses as $address)
                                        <div class="address-card mb-2 p-3 border rounded {{ $defaultAddress && $defaultAddress->id === $address->id ? 'selected' : '' }}">
                                            <label class="d-flex align-items-start cursor-pointer w-100">
                                                <input type="radio"
                                                       name="delivery_address_id"
                                                       value="{{ $address->id }}"
                                                       class="form-check-input me-3 mt-1"
                                                       {{ $defaultAddress && $defaultAddress->id === $address->id ? 'checked' : '' }}>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <strong class="small">{{ $address->full_name }}</strong>
                                                        @if($address->default_delivery)
                                                            <span class="badge-default">VARSAYILAN</span>
                                                        @endif
                                                    </div>
                                                    <p class="mb-0 text-secondary small">{{ $address->full_address }}</p>
                                                    <small class="text-secondary">{{ $address->phone }}</small>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-address-box p-3 border rounded text-center mb-3">
                                    <p class="mb-0 small text-secondary">Kayıtlı teslimat adresiniz bulunmuyor.</p>
                                </div>
                            @endif

                            <button type="button" class="btn-add-address" data-bs-toggle="modal" data-bs-target="#addressModal" data-type="delivery">
                                + Yeni Teslimat Adresi Ekle
                            </button>
                        </div>

                        {{-- Fatura Adresi --}}
                        <div class="checkout-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <span class="step-number me-3">2</span>
                                <h5 class="fw-bold mb-0">Fatura Adresi</h5>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="same-as-delivery" name="same_as_delivery" checked>
                                <label class="form-check-label" for="same-as-delivery">
                                    Fatura adresim teslimat adresimle aynı
                                </label>
                            </div>

                            <div id="billing-address-section" style="display: none;">
                                @if($addresses->count() > 0)
                                    <div class="address-list" id="billing-address-list">
                                        @foreach($addresses as $address)
                                            <div class="address-card mb-2 p-3 border rounded">
                                                <label class="d-flex align-items-start cursor-pointer w-100">
                                                    <input type="radio"
                                                           name="billing_address_id"
                                                           value="{{ $address->id }}"
                                                           class="form-check-input me-3 mt-1">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <strong class="small">{{ $address->full_name }}</strong>
                                                            @if($address->default_billing)
                                                                <span class="badge-default">VARSAYILAN</span>
                                                            @endif
                                                        </div>
                                                        <p class="mb-0 text-secondary small">{{ $address->full_address }}</p>
                                                        @if($address->company_name)
                                                            <small class="text-secondary">{{ $address->company_name }} - {{ $address->tax_number }}</small>
                                                        @elseif($address->identity_number)
                                                            <small class="text-secondary">T.C.: {{ $address->identity_number }}</small>
                                                        @endif
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-address-box p-3 border rounded text-center mb-3">
                                        <p class="mb-0 small text-secondary">Kayıtlı fatura adresiniz bulunmuyor.</p>
                                    </div>
                                @endif

                                <button type="button" class="btn-add-address" data-bs-toggle="modal" data-bs-target="#addressModal" data-type="billing">
                                    + Yeni Fatura Adresi Ekle
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="same_as_delivery_hidden" id="same-as-delivery-hidden" value="1">
                    </form>
                </div>

                {{-- Sağ Kolon - Sipariş Özeti --}}
                <div class="col-lg-5">
                    <div class="checkout-summary p-4 border rounded sticky-top" style="top: 100px;">
                        <div class="section-header d-flex align-items-center mb-4">
                            <span class="step-number me-3">3</span>
                            <h5 class="fw-bold mb-0">Sipariş Özeti</h5>
                        </div>

                        {{-- Ürünler --}}
                        <div class="cart-items mb-4" style="max-height: 250px; overflow-y: auto;">
                            @foreach($cart->items as $item)
                                <div class="cart-item d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div class="me-3">
                                        <img src="{{ $item->image_url }}"
                                             alt="{{ $item->product->name }}"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: contain; background: #f8f8f8;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-0 small">{{ Str::limit($item->product->name, 30) }}</p>
                                        @if($item->variation)
                                            <small class="text-secondary">
                                                {{ $item->variation->selectedOptions()->pluck('name')->implode(' / ') }}
                                            </small>
                                        @endif
                                        <small class="d-block text-secondary">{{ $item->quantity }} adet</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-semibold small">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Fiyat --}}
                        <div class="price-breakdown">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Ara Toplam</span>
                                <span class="small">{{ number_format($cart->subtotal, 2, ',', '.') }} ₺</span>
                            </div>

                            @if($cart->coupon && $cart->discount_amount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">Kupon ({{ $cart->coupon->code }})</span>
                                    <span class="small">-{{ number_format($cart->discount_amount, 2, ',', '.') }} ₺</span>
                                </div>
                            @endif

                            @php
                                $subtotalAfterDiscount = $cart->subtotal - ($cart->discount_amount ?? 0);
                                $shippingCost = $subtotalAfterDiscount >= 500 ? 0 : 29.90;
                                $grandTotal = $subtotalAfterDiscount + $shippingCost;
                            @endphp

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-secondary small">Kargo</span>
                                <span class="small">{{ $shippingCost == 0 ? 'Ücretsiz' : number_format($shippingCost, 2, ',', '.') . ' ₺' }}</span>
                            </div>

                            <hr class="my-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Toplam</strong>
                                <strong class="total-price">{{ number_format($grandTotal, 2, ',', '.') }} ₺</strong>
                            </div>
                        </div>

                        @if($cart->coupon)
                            <div class="applied-coupon-box mt-3">
                                <span><strong>{{ $cart->coupon->code }}</strong> <span class="text-secondary small">uygulandı</span></span>
                                <span class="coupon-badge">{{ $cart->coupon->formatted_value }}</span>
                            </div>
                        @endif

                        <button type="submit"
                                form="checkout-form"
                                class="btn-checkout w-100 mt-4"
                                {{ $addresses->count() === 0 ? 'disabled' : '' }}>
                            <i class="icon-lock me-2"></i>
                            Güvenli Ödemeye Geç
                        </button>
                        <p class="text-center text-secondary small mt-2 mb-0">
                            256-bit SSL ile güvenli ödeme
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Adres Modal --}}
    <div class="modal fade" id="addressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Yeni Adres Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="address-form">
                        <input type="hidden" name="type" id="address-type" value="delivery">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Ad *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Soyad *</label>
                                <input type="text" class="form-control" name="surname" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Telefon *</label>
                                <input type="text" class="form-control" name="phone" placeholder="(5XX) XXX XX XX" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Ülke *</label>
                                <select class="form-select" name="country_id" id="modal-country" required>
                                    <option value="">Seçiniz</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" data-slug="{{ $country->slug }}" {{ $country->name === 'Türkiye' ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">İl *</label>
                                <select class="form-select" name="city_id" id="modal-city" required>
                                    <option value="">Önce ülke seçin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">İlçe *</label>
                                <select class="form-select" name="district_id" id="modal-district" required>
                                    <option value="">Önce il seçin</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small">Adres *</label>
                                <textarea class="form-control" name="address" rows="2" required></textarea>
                            </div>
                        </div>

                        {{-- Fatura Bilgileri (Fatura adresi için) --}}
                        <div id="billing-fields" style="display: none;">
                            <hr class="my-3">
                            <p class="fw-bold small mb-3">Fatura Bilgileri</p>

                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="company_type" id="type-individual" value="individual" checked>
                                    <label class="form-check-label small" for="type-individual">Bireysel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="company_type" id="type-corporate" value="corporate">
                                    <label class="form-check-label small" for="type-corporate">Kurumsal</label>
                                </div>
                            </div>

                            <div id="individual-fields">
                                <div class="col-12">
                                    <label class="form-label small">T.C. Kimlik No</label>
                                    <input type="text" class="form-control" name="identity_number" maxlength="11">
                                </div>
                            </div>

                            <div id="corporate-fields" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small">Şirket Adı</label>
                                        <input type="text" class="form-control" name="company_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Vergi No</label>
                                        <input type="text" class="form-control" name="tax_number">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Vergi Dairesi</label>
                                        <input type="text" class="form-control" name="tax_office">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger mt-3" id="address-error" style="display: none;"></div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn-checkout" id="save-address-btn">Kaydet</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .step-number {
            width: 28px;
            height: 28px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
            flex-shrink: 0;
        }
        .address-card {
            transition: all 0.15s ease;
            cursor: pointer;
            background: #fff;
        }
        .address-card:hover, .address-card.selected {
            border-color: #000 !important;
            background: #fafafa;
        }
        .badge-default {
            font-size: 9px;
            font-weight: 600;
            padding: 2px 6px;
            background: #000;
            color: #fff;
            border-radius: 2px;
        }
        .btn-add-address {
            background: transparent;
            border: 1px dashed #ccc;
            padding: 10px 16px;
            font-size: 13px;
            cursor: pointer;
            width: 100%;
            transition: all 0.15s ease;
        }
        .btn-add-address:hover {
            border-color: #000;
            background: #fafafa;
        }
        .checkout-summary {
            background: #fafafa;
        }
        .total-price {
            font-size: 1.25rem;
        }
        .applied-coupon-box {
            padding: 10px 14px;
            background: #f0f0f0;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .coupon-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 3px 8px;
            background: #000;
            color: #fff;
            border-radius: 2px;
        }
        .btn-checkout {
            background: #000;
            color: #fff;
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-checkout:hover {
            background: #333;
        }
        .btn-checkout:disabled {
            background: #ccc;
        }
        .text-secondary {
            color: #888 !important;
        }
    </style>

@push('scripts')
<script>
$(document).ready(function() {
    // Same as delivery checkbox
    $('#same-as-delivery').change(function() {
        if ($(this).is(':checked')) {
            $('#billing-address-section').slideUp();
            $('#same-as-delivery-hidden').val('1');
        } else {
            $('#billing-address-section').slideDown();
            $('#same-as-delivery-hidden').val('0');
        }
    });

    // Address type for modal
    $('[data-bs-target="#addressModal"]').click(function() {
        const type = $(this).data('type');
        $('#address-type').val(type);
        
        if (type === 'billing') {
            $('#billing-fields').show();
        } else {
            $('#billing-fields').hide();
        }
    });

    // Company type toggle
    $('input[name="company_type"]').change(function() {
        if ($(this).val() === 'corporate') {
            $('#individual-fields').hide();
            $('#corporate-fields').show();
        } else {
            $('#individual-fields').show();
            $('#corporate-fields').hide();
        }
    });

    // Load cities on country change (using slug-based routes)
    $('#modal-country').change(function() {
        const $selected = $(this).find('option:selected');
        const countrySlug = $selected.data('slug');
        if (!countrySlug) return;
        
        $.get(`/profil/cities/${countrySlug}`, function(response) {
            let options = '<option value="">Seçiniz</option>';
            response.data.forEach(city => {
                options += `<option value="${city.id}" data-slug="${city.slug}">${city.name}</option>`;
            });
            $('#modal-city').html(options);
            $('#modal-district').html('<option value="">Önce il seçin</option>');
        });
    });

    // Load districts on city change (using slug-based routes)
    $('#modal-city').change(function() {
        const $selected = $(this).find('option:selected');
        const citySlug = $selected.data('slug');
        if (!citySlug) return;
        
        $.get(`/profil/districts/${citySlug}`, function(response) {
            let options = '<option value="">Seçiniz</option>';
            response.data.forEach(district => {
                options += `<option value="${district.id}">${district.name}</option>`;
            });
            $('#modal-district').html(options);
        });
    });

    // Trigger city load for Turkey
    if ($('#modal-country').val()) {
        $('#modal-country').trigger('change');
    }

    // Save address
    $('#save-address-btn').click(function() {
        const $btn = $(this);
        const $error = $('#address-error');
        
        $btn.prop('disabled', true).text('Kaydediliyor...');
        $error.hide();

        const formData = $('#address-form').serializeArray();
        const data = {};
        formData.forEach(item => data[item.name] = item.value);

        $.ajax({
            url: '{{ route("account.address.storeAjax") }}',
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Add to list
                    const type = data.type;
                    const listId = type === 'billing' ? '#billing-address-list' : '#delivery-address-list';
                    
                    const html = `
                        <div class="address-card mb-2 p-3 border rounded">
                            <label class="d-flex align-items-start cursor-pointer w-100">
                                <input type="radio" name="${type}_address_id" value="${response.data.id}" class="form-check-input me-3 mt-1" checked>
                                <div class="flex-grow-1">
                                    <strong class="small">${response.data.full_name}</strong>
                                    <p class="mb-0 text-secondary small">${response.data.full_address}</p>
                                    <small class="text-secondary">${response.data.phone}</small>
                                </div>
                            </label>
                        </div>
                    `;
                    
                    $(listId).append(html);
                    $('#addressModal').modal('hide');
                    $('#address-form')[0].reset();
                    
                    // Enable submit if first address
                    $('button[type="submit"]').prop('disabled', false);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                const messages = Object.values(errors).flat().join('<br>');
                $error.html(messages || 'Bir hata oluştu.').show();
            },
            complete: function() {
                $btn.prop('disabled', false).text('Kaydet');
            }
        });
    });

    // Card selection highlight
    $(document).on('change', 'input[type="radio"]', function() {
        const name = $(this).attr('name');
        $(`input[name="${name}"]`).closest('.address-card').removeClass('selected');
        $(this).closest('.address-card').addClass('selected');
    });
});
</script>
@endpush
@endsection
