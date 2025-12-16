@extends('app.layouts.main')
@section('title', $product->name)

@push('css')
    <link rel="stylesheet" href="{{ asset('front/css/drift-basic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/photoswipe.css') }}">
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="tf-breadcrumb">
        <div class="container">
            <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
                <div class="tf-breadcrumb-list">
                    <a href="{{ route('home') }}" class="text">Ana Sayfa</a>
                    <i class="icon icon-arrow-right"></i>
                    <a href="{{ route('category.show', ['slug' => $product->category->slug]) }}" class="text">
                        {{ $product->category->name }}
                    </a>
                    <i class="icon icon-arrow-right"></i>
                    <span class="text">{{ $product->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <section class="flat-spacing-4 pt_0">
        <div class="tf-main-product section-image-zoom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tf-product-media-wrap sticky-top">
                            <div class="thumbs-slider">


                                <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom"
                                     data-direction="vertical">
                                    <div class="swiper-wrapper stagger-wrap">
                                        @foreach($galleryImages as $media)
                                            <div class="swiper-slide stagger-item">
                                                <div class="item">
                                                    <img class="lazyload product-media-thumb"
                                                         data-src="{{ $media->getUrl('thumb') }}"
                                                         src="{{ $media->getUrl('thumb') }}"
                                                         alt="{{ $product->name }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                                <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                    <div class="swiper-wrapper main-media-wrapper">
                                        @foreach($galleryImages as $media)
                                            <div class="swiper-slide">
                                                <a href="{{ $media->getUrl() }}" target="_blank" class="item"
                                                   data-pswp-width="770px" data-pswp-height="1075px">
                                                    <img class="tf-image-zoom lazyload main-media-img"
                                                         data-zoom="{{ $media->getUrl() }}"
                                                         data-src="{{ $media->getUrl() }}"
                                                         src="{{ $media->getUrl() }}"
                                                         alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="swiper-button-next button-style-arrow thumbs-next"></div>
                                    <div class="swiper-button-prev button-style-arrow thumbs-prev"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tf-product-info-wrap position-relative">
                            <div class="tf-zoom-main"></div>
                            <div class="tf-product-info-list other-image-zoom">

                                <div class="tf-product-info-title">
                                    <h5>{{ $product->name }}</h5>
                                </div>
                                <div class="tf-product-info-badges">
                                    @if($product->is_new)
                                        <div class="badge bg-success-subtle text-success">Yeni</div>
                                    @endif
                                    @if($product->is_best_seller)
                                        <div class="badge bg-warning-subtle text-warning">Çok Satan</div>
                                    @endif
                                    @if($product->is_featured)
                                        <div class="badge bg-primary-subtle text-primary">Öne Çıkan</div>
                                    @endif

                                    @if(!$hasStock)
                                        <div class="badge bg-danger-subtle text-danger">Stok Tükendi</div>
                                    @endif
                                </div>
                                <div class="tf-product-info-price">
                                    <div class="price">
                                        @if($currentDiscountPrice && $currentDiscountPrice < $currentSellingPrice)
                                            <div
                                                class="price-on-sale">{{ number_format($currentDiscountPrice, 2, ',', '.') }} ₺
                                            </div>
                                            <div
                                                class="compare-at-price">{{ number_format($currentSellingPrice, 2, ',', '.') }} ₺
                                            </div>
                                            <div class="badge text-bg-danger">
                                                -{{ round((($currentSellingPrice - $currentDiscountPrice) / $currentSellingPrice) * 100) }} %
                                            </div>
                                        @else
                                            <div
                                                class="price-on-sale">{{ number_format($currentSellingPrice, 2, ',', '.') }}
                                                ₺
                                            </div>
                                        @endif
                                    </div>

                                    <div class="fs-12 text-muted mt-2">
                                        @if($selectedVariation)
                                            SKU: <strong>{{ $selectedVariation->sku }}</strong>
                                        @endif
                                    </div>
                                </div>


                                @if($product->short_description)
                                    <div class="tf-product-info-description">
                                        <p>{{ $product->short_description }}</p>
                                    </div>
                                @endif


                                @if($product->variationTypes->isNotEmpty())
                                    <div class="tf-product-info-variant-picker">
                                        @foreach($product->variationTypes as $variationType)
                                            <div class="variant-picker-item mb-3">
                                                <div class="variant-picker-label mb-2">
                                                    {{ $variationType->name }}:
                                                    <span class="fw-6 variant-picker-label-value text-primary">
                                                        {{ $variationType->options->whereIn('id', $selectedOptionIds)->first()?->name }}
                                                    </span>
                                                </div>

                                                <div class="variant-picker-values">
                                                    @foreach($variationType->options as $option)
                                                        @php
                                                            $isAvailable = in_array($option->id, $availableOptionsByType[$variationType->id] ?? []);
                                                        @endphp


                                                        <input type="radio"
                                                               name="group_{{ $variationType->id }}"
                                                               id="option-{{ $option->id }}"
                                                               value="{{ $option->id }}"
                                                               class="variation-option-input d-none"
                                                            @checked(in_array($option->id, $selectedOptionIds))
                                                            @disabled(!$isAvailable)>


                                                        @if($variationType->type->value === 'image')
                                                            <label
                                                                @class(['style-image', 'hover-tooltip', 'variation-label', 'active' => in_array($option->id, $selectedOptionIds), 'disabled' => !$isAvailable])
                                                                for="option-{{ $option->id }}"
                                                                @if(!$isAvailable) style="opacity: 0.4; pointer-events: none; cursor: not-allowed;" @endif>
                                                                <div class="image">
                                                                    <img class="lazyloaded"
                                                                         src="{{ $option->getFirstMediaUrl('images', 'thumb') ?: asset('front/images/default.jpg') }}"
                                                                         alt="{{ $option->name }}">
                                                                </div>
                                                                <span
                                                                    class="tooltip">{{ $option->name }}@if(!$isAvailable)
                                                                        (Mevcut Değil)
                                                                    @endif</span>
                                                            </label>

                                                        @elseif($variationType->type->value === 'color' || $variationType->type->value === 'select')
                                                            <label
                                                                @class(['style-color', 'hover-tooltip', 'variation-label', 'active' => in_array($option->id, $selectedOptionIds), 'disabled' => !$isAvailable])
                                                                for="option-{{ $option->id }}"
                                                                @if(!$isAvailable) style="opacity: 0.4; pointer-events: none; cursor: not-allowed;" @endif>
                                                                <span class="btn-checkbox"
                                                                      style="background-color: {{ $option->color_code ?? '#cccccc' }}"></span>
                                                                <span
                                                                    class="tooltip">{{ $option->name }}@if(!$isAvailable)
                                                                        (Mevcut Değil)
                                                                    @endif</span>
                                                            </label>

                                                        @else
                                                            <label
                                                                @class(['style-text', 'variation-label', 'active' => in_array($option->id, $selectedOptionIds), 'disabled' => !$isAvailable])
                                                                for="option-{{ $option->id }}"
                                                                @if(!$isAvailable) style="opacity: 0.4; pointer-events: none; cursor: not-allowed;" @endif>
                                                                <p>{{ $option->name }}@if(!$isAvailable)
                                                                        (Mevcut Değil)
                                                                    @endif</p>
                                                            </label>
                                                        @endif

                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif


                                <div class="tf-product-info-quantity mt-4">
                                    <div class="quantity-title fw-6">Miktar</div>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity minus-qty">-</span>
                                        <input type="number" class="quantity-product" id="product-quantity"
                                               name="quantity" value="1" min="1" max="{{ $currentStock }}">
                                        <span class="btn-quantity plus-qty">+</span>
                                    </div>
                                </div>

                                <div class="tf-product-info-buy-button">
                                    <button type="button"
                                            class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1"
                                            id="add-to-cart-btn"
                                            data-product-id="{{ $product->id }}"
                                            data-variation-id="{{ $selectedVariation?->id }}"
                                        @disabled(!$hasStock)>
                                        @if($hasStock)
                                            <span class="btn-text">Sepete Ekle - {{ number_format($currentDiscountPrice ?: $currentSellingPrice, 2, ',', '.') }} ₺</span>
                                            <span class="btn-loading d-none">
                                                <i class="icon icon-loading"></i> Ekleniyor...
                                            </span>
                                        @else
                                            <span>Stok Tükendi</span>
                                        @endif
                                    </button>
                                </div>

                                <div class="tf-product-info-extra-link">
                                    <a href="#delivery_return" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon"><i class="icon-delivery-time"></i></div>
                                        <div class="text fw-6">Teslimat & İade</div>
                                    </a>
                                </div>

                                <div class="tf-product-info-trust-seal">
                                    <div class="tf-product-trust-mess">
                                        <i class="icon-safe"></i>
                                        <p class="fw-6">Güvenli <br> Ödeme</p>
                                    </div>
                                    <div class="tf-payment">
                                        <img src="{{ asset('front/images/payments/visa.png') }}" alt="Visa">
                                        <img src="{{ asset('front/images/payments/img-1.png') }}" alt="Mastercard">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('front/js/model-viewer.min.js') }}"></script>
    <script type="module" src="{{ asset('front/js/zoom.js') }}"></script>
    <script type="module" src="{{ asset('front/js/drift.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.13.2/dist/axios.min.js"></script>

    <script>
        $(document).ready(() => {
            axios.defaults.headers.common['X-CSRF-TOKEN'] =
                $('meta[name="csrf-token"]').attr('content');

            axios.defaults.headers.common['Accept'] = 'application/json';


            const $quantityInput = $('#product-quantity');
            const maxStock = parseInt($quantityInput.attr('max'), 10) || 99;
            const unitPrice = {{ $currentDiscountPrice ?: $currentSellingPrice }};

            const updateButtonPrice = () => {
                const quantity = parseInt($quantityInput.val(), 10) || 1;
                const totalPrice = (unitPrice * quantity).toLocaleString('tr-TR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $('#add-to-cart-btn .btn-text').text(`Sepete Ekle - ${totalPrice} ₺`);
            };

            const updateCartCount = (count) => {
                $('.cart-count, .toolbar-count, .count-box').text(count);
            };

            const showToast = (message, type = 'success') => {
                const bgColor = type === 'success' ? '#28a745' : '#dc3545';
                const iconClass = type === 'success' ? 'icon-check' : 'icon-close';

                const $toast = $(`
            <div class="toast-notification toast-${type}">
                <div class="toast-content">
                    <i class="icon ${iconClass}"></i>
                    <span>${message}</span>
                </div>
            </div>
        `);

                $toast.css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    background: bgColor,
                    color: 'white',
                    padding: '15px 25px',
                    borderRadius: '8px',
                    zIndex: 9999,
                    animation: 'slideIn 0.3s ease',
                    boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
                });

                $('body').append($toast);

                setTimeout(() => {
                    $toast.css('animation', 'slideOut 0.3s ease');
                    setTimeout(() => $toast.remove(), 300);
                }, 3000);
            };

            const handleAddToCart = async () => {
                const $btn = $('#add-to-cart-btn');
                const $btnText = $btn.find('.btn-text');
                const $btnLoading = $btn.find('.btn-loading');

                const productId = $btn.data('product-id');
                const variationId = $btn.data('variation-id') || null;
                const quantity = parseInt($quantityInput.val(), 10) || 1;

                $btnText.addClass('d-none');
                $btnLoading.removeClass('d-none');
                $btn.prop('disabled', true);

                try {
                    const {data} = await axios.post('{{ route("cart.store") }}', {
                        product_id: productId,
                        variation_id: variationId,
                        quantity
                    });

                    if (!data.success) {
                        showToast(data.message || 'Bir hata oluştu', 'error');
                        return;
                    }

                    showToast('Ürün sepete eklendi!', 'success');

                    updateCartCount(data.cart_count);

                    if (window.refreshMiniCart) {
                        window.refreshMiniCart();
                    }

                    $('#shoppingCart').modal('show');

                } catch (error) {
                    console.error('Add to cart error:', error);
                    const message = error.response?.data?.message || 'Bir hata oluştu';
                    showToast(message, 'error');
                } finally {
                    $btnText.removeClass('d-none');
                    $btnLoading.addClass('d-none');
                    $btn.prop('disabled', false);
                }
            };

            $('.variation-option-input').on('change', () => {
                $('body').css('cursor', 'wait');
                $('.tf-product-info-variant-picker').css('opacity', '0.6');

                const params = new URLSearchParams();

                $('.variation-option-input:checked').each(function () {
                    params.append('options[]', $(this).val());
                });

                window.location.search = params.toString();
            });

            $('.minus-qty').on('click', () => {
                const currentVal = parseInt($quantityInput.val(), 10) || 1;
                if (currentVal > 1) {
                    $quantityInput.val(currentVal - 1);
                    updateButtonPrice();
                }
            });

            $('.plus-qty').on('click', () => {
                const currentVal = parseInt($quantityInput.val(), 10) || 1;
                if (currentVal < maxStock) {
                    $quantityInput.val(currentVal + 1);
                    updateButtonPrice();
                }
            });

            $quantityInput.on('input change', () => {
                updateButtonPrice();
            });

            $('#add-to-cart-btn').on('click', handleAddToCart);

            window.showToast = showToast;
            window.updateCartCount = updateCartCount;
        });
    </script>

@endpush
