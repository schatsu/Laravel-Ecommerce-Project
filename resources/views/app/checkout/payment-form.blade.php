@extends('app.layouts.main')
@section('title', 'Ödeme')
@push('css')
    <style>
        .step-number {
            width: 40px;
            height: 40px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .card-input-wrapper {
            position: relative;
        }
        .card-type-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 25px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        .card-type-icon.visa {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="%231A1F71" d="M44,37c0,2.209-1.791,4-4,4H8c-2.209,0-4-1.791-4-4V11c0-2.209,1.791-4,4-4h32c2.209,0,4,1.791,4,4V37z"/><path fill="%23FFF" d="M19.077,28.918l1.674-10.404h2.676l-1.674,10.404H19.077z"/><path fill="%23FFF" d="M31.922,18.666c-0.529-0.199-1.359-0.411-2.396-0.411c-2.641,0-4.504,1.407-4.517,3.422c-0.013,1.489,1.331,2.319,2.346,2.815c1.042,0.508,1.392,0.833,1.388,1.287c-0.007,0.696-0.832,1.014-1.602,1.014c-1.071,0-1.64-0.158-2.519-0.545l-0.345-0.166l-0.376,2.33c0.625,0.29,1.783,0.541,2.983,0.554c2.809,0,4.633-1.387,4.657-3.543c0.012-1.181-0.705-2.08-2.252-2.82c-0.938-0.479-1.512-0.799-1.505-1.285c0-0.431,0.485-0.892,1.535-0.892c0.876-0.014,1.511,0.189,2.005,0.398l0.24,0.121L31.922,18.666z"/><path fill="%23FFF" d="M38.453,18.514h-2.066c-0.641,0-1.119,0.184-1.401,0.858l-3.971,9.546h2.808l0.561-1.557l3.426,0.003c0.08,0.363,0.325,1.554,0.325,1.554h2.479L38.453,18.514z M34.802,25.074c0.222-0.602,1.069-2.921,1.069-2.921c-0.016,0.028,0.22-0.604,0.355-0.996l0.182,0.9c0,0,0.514,2.49,0.621,3.017H34.802z"/><path fill="%23FFF" d="M15.804,18.514l-2.617,7.091l-0.279-1.436c-0.487-1.654-2.005-3.448-3.702-4.346l2.394,9.083l2.829-0.003l4.208-10.389H15.804z"/><path fill="%23F7B600" d="M10.627,18.514H6.295l-0.039,0.206c3.352,0.857,5.572,2.929,6.492,5.419l-0.936-4.764C11.641,18.723,11.189,18.538,10.627,18.514z"/></svg>');
        }
        .card-type-icon.mastercard {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="%23FF5F00" d="M18,24c0,4.418,3.582,8,8,8s8-3.582,8-8s-3.582-8-8-8S18,19.582,18,24z"/><path fill="%23EB001B" d="M18,24c0-4.418,3.582-8,8-8c-1.667-1.245-3.737-2-6-2c-5.523,0-10,4.477-10,10s4.477,10,10,10c2.263,0,4.333-0.755,6-2C21.582,32,18,28.418,18,24z"/><path fill="%23F79E1B" d="M38,24c0,5.523-4.477,10-10,10c-2.263,0-4.333-0.755-6-2c4.418,0,8-3.582,8-8s-3.582-8-8-8c1.667-1.245,3.737-2,6-2C33.523,14,38,18.477,38,24z"/></svg>');
        }
        .card-type-icon.troy {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><rect fill="%230055A4" width="48" height="48" rx="4"/><text x="24" y="28" fill="white" font-size="12" text-anchor="middle" font-weight="bold">TROY</text></svg>');
        }
        .form-control-lg {
            padding: 14px 16px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-control-lg:focus {
            border-color: #000;
            box-shadow: none;
        }
        .installment-option {
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .installment-option:hover {
            border-color: #000;
        }
        .installment-option.selected {
            border-color: #000;
            background: #fafafa;
        }
        .installment-option input {
            display: none;
        }
        .order-summary-card {
            background: #fafafa;
        }
        .total-price {
            font-size: 1.25rem;
        }
        .btn-checkout {
            background: #000;
            color: #fff;
            border: none;
            padding: 16px 24px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }
        .btn-checkout:hover {
            background: #333;
        }
        .btn-checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
@endpush
@section('content')
    <x-page-title-component :name="'Ödeme'"/>

    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="payment-form-section">
                        <div class="section-header d-flex align-items-center mb-4">
                            <span class="step-number me-3">
                                <i class="icon-credit-card"></i>
                            </span>
                            <h5 class="fw-bold mb-0">Kart Bilgileri</h5>
                        </div>

                        <form action="{{ route('checkout.pay') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="mb-4">
                                <label class="form-label small">Kart Numarası</label>
                                <div class="card-input-wrapper">
                                    <input type="text"
                                           class="form-control form-control-lg"
                                           name="card_number"
                                           id="card-number"
                                           placeholder="0000 0000 0000 0000"
                                           maxlength="19"
                                           autocomplete="cc-number"
                                           required>
                                    <div class="card-type-icon" id="card-type-icon"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small">Kart Üzerindeki İsim</label>
                                <input type="text"
                                       class="form-control form-control-lg"
                                       name="holder_name"
                                       id="holder-name"
                                       placeholder="AD SOYAD"
                                       autocomplete="cc-name"
                                       style="text-transform: uppercase;"
                                       required>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-4">
                                    <label class="form-label small">Son Kullanma Tarihi</label>
                                    <input type="text"
                                           class="form-control form-control-lg"
                                           name="expire_date"
                                           id="expire-date"
                                           placeholder="AA/YY"
                                           maxlength="5"
                                           autocomplete="cc-exp"
                                           required>
                                </div>

                                <div class="col-6 mb-4">
                                    <label class="form-label small">CVV</label>
                                    <input type="text"
                                           class="form-control form-control-lg"
                                           name="cvc"
                                           id="cvc"
                                           placeholder="•••"
                                           maxlength="4"
                                           autocomplete="cc-csc"
                                           required>
                                </div>
                            </div>

                            <div class="installment-section mb-4" id="installment-section" style="display: none;">
                                <label class="form-label small mb-3">Taksit Seçenekleri</label>
                                <div class="installment-options" id="installment-options">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="use_3d_secure" id="use-3d-secure" value="1" checked>
                                    <label class="form-check-label" for="use-3d-secure">
                                        <span class="fw-medium">3D Secure ile öde</span>
                                        <small class="d-block text-secondary">Ekstra güvenlik için önerilir</small>
                                    </label>
                                </div>
                            </div>

                            <div class="alert alert-danger" id="payment-error" style="display: none;"></div>

                            <button type="submit" class="btn-checkout w-100 mt-3" id="pay-button">
                                <i class="icon-lock me-2"></i>
                                <span id="pay-button-text">{{ number_format($order->total, 2, ',', '.') }} ₺ Öde</span>
                            </button>

                            <p class="text-center text-secondary small mt-3 mb-0">
                                <i class="icon-shield me-1"></i>
                                256-bit SSL ile şifrelenmiş güvenli ödeme
                            </p>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="order-summary-card p-4 border rounded sticky-top" style="top: 100px;">
                        <h6 class="fw-bold mb-4">Sipariş Özeti</h6>

                        <div class="order-items mb-4" style="max-height: 200px; overflow-y: auto;">
                            @foreach($order->items as $item)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <img src="{{ $item->product?->getFirstMediaUrl('images') ?: asset('images/placeholder.png') }}"
                                             class="rounded"
                                             style="width: 50px; height: 50px; object-fit: contain; background: #f8f8f8;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small mb-0">{{ Str::limit($item->name, 30) }}</p>
                                        <small class="text-secondary">{{ $item->quantity }} adet</small>
                                    </div>
                                    <span class="small">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary small">Ara Toplam</span>
                            <span class="small">{{ number_format($order->subtotal, 2, ',', '.') }} ₺</span>
                        </div>

                        @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small">İndirim</span>
                                <span class="small">-{{ number_format($order->discount_amount, 2, ',', '.') }} ₺</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary small">Kargo</span>
                            <span class="small">{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', '.') . ' ₺' : 'Ücretsiz' }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <strong>Toplam</strong>
                            <strong class="total-price" id="display-total">{{ number_format($order->total, 2, ',', '.') }} ₺</strong>
                        </div>

                        {{-- Teslimat Adresi --}}
                        <div class="mt-4 pt-3 border-top">
                            <p class="small text-secondary mb-1">Teslimat Adresi</p>
                            <p class="small mb-0">
                                {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
                                {{ $order->shipping_address['address'] ?? '' }}<br>
                                {{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const $cardNumber = $('#card-number');
            const $expireDate = $('#expire-date');
            const $cvc = $('#cvc');
            const $holderName = $('#holder-name');
            const $cardTypeIcon = $('#card-type-icon');
            const $installmentSection = $('#installment-section');
            const $installmentOptions = $('#installment-options');
            const $payButton = $('#pay-button');
            const $payButtonText = $('#pay-button-text');
            const $paymentError = $('#payment-error');

            const orderTotal = {{ $order->total }};

            $cardNumber.on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                value = value.substring(0, 16);

                let formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                $(this).val(formatted);

                detectCardType(value);

                if (value.length >= 6) {
                    getInstallmentOptions(value.substring(0, 6));
                } else {
                    $installmentSection.hide();
                }
            });

            $expireDate.on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                $(this).val(value);
            });

            $cvc.on('input', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });

            $holderName.on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            function detectCardType(number) {
                $cardTypeIcon.removeClass('visa mastercard troy');

                if (/^4/.test(number)) {
                    $cardTypeIcon.addClass('visa');
                } else if (/^5[1-5]/.test(number) || /^2[2-7]/.test(number)) {
                    $cardTypeIcon.addClass('mastercard');
                } else if (/^9792/.test(number)) {
                    $cardTypeIcon.addClass('troy');
                }
            }

            function luhnCheck(num) {
                let arr = (num + '').split('').reverse().map(x => parseInt(x));
                let sum = arr.reduce((acc, val, i) => {
                    if (i % 2 !== 0) {
                        val = val * 2;
                        if (val > 9) val = val - 9;
                    }
                    return acc + val;
                }, 0);
                return sum % 10 === 0;
            }

            function getInstallmentOptions(bin) {
                axios.get(`{{ route('checkout.installments', ['bin' => '__BIN__', 'price' => '__PRICE__']) }}`.replace('__BIN__', bin).replace('__PRICE__', orderTotal))
                    .then(function(res) {
                        const response = res.data;
                        if (response.success && response.installments.length > 0) {
                            let html = '';
                            response.installments.forEach(function(inst, index) {
                                const checked = index === 0 ? 'checked' : '';
                                const selected = index === 0 ? 'selected' : '';
                                html += `
                            <label class="installment-option d-flex justify-content-between align-items-center ${selected}">
                                <input type="radio" name="installment" value="${inst.installment}" ${checked}>
                                <span>${inst.installment === 1 ? 'Tek Çekim' : inst.installment + ' Taksit'}</span>
                                <strong>${inst.total_price} ₺</strong>
                            </label>
                        `;
                            });
                            $installmentOptions.html(html);
                            $installmentSection.show();

                            $('.installment-option').click(function() {
                                $('.installment-option').removeClass('selected');
                                $(this).addClass('selected');
                                $(this).find('input').prop('checked', true);

                                const total = $(this).find('strong').text();
                                $('#display-total').text(total);
                                $payButtonText.text(total + ' Öde');
                            });
                        }
                    });
            }

            $('#payment-form').on('submit', function(e) {
                $paymentError.hide();

                const cardNum = $cardNumber.val().replace(/\s/g, '');
                if (cardNum.length < 15 || !luhnCheck(cardNum)) {
                    e.preventDefault();
                    $paymentError.text('Geçersiz kart numarası').show();
                    return;
                }

                const expire = $expireDate.val();
                if (!/^\d{2}\/\d{2}$/.test(expire)) {
                    e.preventDefault();
                    $paymentError.text('Geçersiz son kullanma tarihi').show();
                    return;
                }

                const cvc = $cvc.val();
                if (cvc.length < 3) {
                    e.preventDefault();
                    $paymentError.text('Geçersiz CVV').show();
                    return;
                }

                $payButton.prop('disabled', true);
                $payButtonText.text('İşleniyor...');
            });
        });
    </script>
@endpush
