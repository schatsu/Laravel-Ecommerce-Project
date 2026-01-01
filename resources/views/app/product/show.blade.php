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

        #add-to-favorite-btn {
            width: 52px;
            height: 52px;
            min-width: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            border: 1px solid #ebebeb;
            background: #fff;
            transition: all 0.3s ease;
        }

        #add-to-favorite-btn:hover {
            background: #000;
            border-color: #000;
        }

        #add-to-favorite-btn:hover i {
            color: #fff !important;
        }

        #add-to-favorite-btn.favorited i {
            color: #e74c3c !important;
        }

        #add-to-favorite-btn.favorited:hover i {
            color: #fff !important;
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
                                        <div class="badge" style="background: #1a1a1a; color: #C0C0C0; font-weight: 500; padding: 5px 14px; border-radius: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #333;">Yeni</div>
                                    @endif
                                    @if($product->is_best_seller)
                                        <div class="badge" style="background: #1a1a1a; color: #D4AF37; font-weight: 500; padding: 5px 14px; border-radius: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #333;">Çok Satan</div>
                                    @endif
                                    @if($product->is_featured)
                                        <div class="badge" style="background: #1a1a1a; color: #E5E4E2; font-weight: 500; padding: 5px 14px; border-radius: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #333;">Öne Çıkan</div>
                                    @endif

                                    @if(!$hasStock)
                                        <div class="badge" style="background: #2d2d2d; color: #999; font-weight: 500; padding: 5px 14px; border-radius: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border: 1px solid #444;">Stok Tükendi</div>
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

                                <div class="tf-product-info-buy-button d-flex gap-2">
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
                                    <button type="button"
                                            class="{{ auth()->check() && auth()->user()->hasFavorited($product) ? 'favorited' : '' }}"
                                            id="add-to-favorite-btn"
                                            data-product-slug="{{ $product->slug }}"
                                            title="Favorilere Ekle">
                                        @auth
                                            @if(auth()->user()->hasFavorited($product))
                                                <i class="icon-heart-full" style="font-size: 18px;"></i>
                                            @else
                                                <i class="icon-heart" style="font-size: 18px;"></i>
                                            @endif
                                        @else
                                            <i class="icon-heart" style="font-size: 18px;"></i>
                                        @endauth
                                    </button>
                                </div>
                                <div class="tf-product-info-extra-link">
                                    <a href="#delivery_return" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon">
                                            <svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="currentColor">
                                                <path d="M21.7872 10.4724C21.7872 9.73685 21.5432 9.00864 21.1002 8.4217L18.7221 5.27043C18.2421 4.63481 17.4804 4.25532 16.684 4.25532H14.9787V2.54885C14.9787 1.14111 13.8334 0 12.4255 0H9.95745V1.69779H12.4255C12.8948 1.69779 13.2766 2.07962 13.2766 2.54885V14.5957H8.15145C7.80021 13.6052 6.85421 12.8936 5.74468 12.8936C4.63515 12.8936 3.68915 13.6052 3.33792 14.5957H2.55319C2.08396 14.5957 1.70213 14.2139 1.70213 13.7447V2.54885C1.70213 2.07962 2.08396 1.69779 2.55319 1.69779H9.95745V0H2.55319C1.14528 0 0 1.14111 0 2.54885V13.7447C0 15.1526 1.14528 16.2979 2.55319 16.2979H3.33792C3.68915 17.2884 4.63515 18 5.74468 18C6.85421 18 7.80021 17.2884 8.15145 16.2979H13.423C13.7742 17.2884 14.7202 18 15.8297 18C16.9393 18 17.8853 17.2884 18.2365 16.2979H21.7872V10.4724ZM16.684 5.95745C16.9494 5.95745 17.2034 6.08396 17.3634 6.29574L19.5166 9.14894H14.9787V5.95745H16.684ZM5.74468 16.2979C5.27545 16.2979 4.89362 15.916 4.89362 15.4468C4.89362 14.9776 5.27545 14.5957 5.74468 14.5957C6.21392 14.5957 6.59575 14.9776 6.59575 15.4468C6.59575 15.916 6.21392 16.2979 5.74468 16.2979ZM15.8298 16.2979C15.3606 16.2979 14.9787 15.916 14.9787 15.4468C14.9787 14.9776 15.3606 14.5957 15.8298 14.5957C16.299 14.5957 16.6809 14.9776 16.6809 15.4468C16.6809 15.916 16.299 16.2979 15.8298 16.2979ZM18.2366 14.5957C17.8853 13.6052 16.9393 12.8936 15.8298 12.8936C15.5398 12.8935 15.252 12.943 14.9787 13.04V10.8511H20.0851V14.5957H18.2366Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text fw-6">Kargo &amp; Teslimat</div>
                                    </a>
                                    <a href="#share_social" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon">
                                            <i class="icon-share"></i>
                                        </div>
                                        <div class="text fw-6">Paylaş</div>
                                    </a>
                                </div>

                                <div class="tf-product-info-trust-seal">
                                    <div class="tf-product-trust-mess">
                                        <i class="icon-safe"></i>
                                        <p class="fw-6">Güvenli <br> Ödeme</p>
                                    </div>
                                    <div class="tf-payment">
                                        <img src="{{ asset('front/images/shop/products/visa.png') }}" alt="Visa">
                                        <img src="{{ asset('front/images/shop/products/mastercard.png') }}" alt="Mastercard">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- modal delivery_return -->
    <div class="modal modalCentered fade modalDemo tf-product-modal modal-part-content" id="delivery_return">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Kargo & Teslim</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <div class="tf-product-popup-delivery">
                        {!! str($shippingPage->content)->markdown()->sanitizeHtml() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal delivery_return -->
    <!-- modal share social -->
    <div class="modal modalCentered fade modalDemo tf-product-modal modal-part-content" id="share_social">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Paylaş</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <ul class="tf-social-icon d-flex gap-10">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('product.show', ['slug' => $product->slug])) }}" target="_blank" rel="noopener noreferrer" class="box-icon social-facebook bg_line"><i class="icon icon-fb"></i></a></li>
                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('product.show', ['slug' => $product->slug])) }}&text={{ urlencode($product->name) }}" target="_blank" rel="noopener noreferrer" class="box-icon social-twiter bg_line"><i class="icon icon-Icon-x"></i></a></li>
                        <li><a href="https://pinterest.com/pin/create/button/?url={{ urlencode(route('product.show', ['slug' => $product->slug])) }}&description={{ urlencode($product->name) }}" target="_blank" rel="noopener noreferrer" class="box-icon social-pinterest bg_line"><i class="icon icon-pinterest-1"></i></a></li>
                    </ul>
                    <form class="form-share" action="javascript:void(0);">
                        <fieldset>
                            <input type="text" id="share-url-input" value="{{ route('product.show', ['slug' => $product->slug]) }}" tabindex="0" aria-required="true" readonly>
                        </fieldset>
                        <div class="button-submit">
                            <button class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn" type="button" id="copy-link-btn">Kopyala</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal share social -->

    <!-- tabs -->
    <section class="flat-spacing-17 pt_0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="widget-tabs style-has-border">
                        <ul class="widget-menu-tab">
                            <li class="item-title active">
                                <span class="inner">Açıklama</span>
                            </li>
                            @if($product->variationTypes->isNotEmpty())
                                <li class="item-title">
                                    <span class="inner">Additional Information</span>
                                </li>
                            @endif
                            <li class="item-title">
                                <span class="inner">Yorumlar</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Kargo</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">İade Politikası</span>
                            </li>
                        </ul>
                        <div class="widget-content-tab">
                            <div class="widget-content-inner active">
                                <div class="">
                                    {!! str($product->description)->markdown()->sanitizeHtml() !!}
                                </div>
                            </div>
                            @if($product->variationTypes->isNotEmpty())
                                <div class="widget-content-inner">
                                    <table class="tf-pr-attrs">
                                        <tbody>
                                        <tr class="tf-attr-pa-color">
                                            <th class="tf-attr-label">Color</th>
                                            <td class="tf-attr-value">
                                                <p>White, Pink, Black</p>
                                            </td>
                                        </tr>
                                        <tr class="tf-attr-pa-size">
                                            <th class="tf-attr-label">Size</th>
                                            <td class="tf-attr-value">
                                                <p>S, M, L, XL</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <div class="widget-content-inner">
                                <div class="tab-reviews write-cancel-review-wrap">
                                    <div class="tab-reviews-heading">
                                        <div class="top">
                                            <div class="text-center">
                                                <h1 class="number fw-6">{{ $averageRating > 0 ? number_format($averageRating, 1) : '-' }}</h1>
                                                <div class="list-star">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($averageRating))
                                                            <i class="icon icon-star" style="color: #ffc107;"></i>
                                                        @else
                                                            <i class="icon icon-star" style="color: #e0e0e0;"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p>({{ $reviewsCount }} Değerlendirme)</p>
                                            </div>
                                            <div class="rating-score">
                                                @foreach($ratingDistribution as $star => $data)
                                                    <div class="item">
                                                        <div class="number-1 text-caption-1">{{ $star }}</div>
                                                        <i class="icon icon-star" style="color: #ffc107;"></i>
                                                        <div class="line-bg">
                                                            <div style="width: {{ $data['percentage'] }}%;"></div>
                                                        </div>
                                                        <div class="number-2 text-caption-1">{{ $data['count'] }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @auth
                                            @if($userReview)
                                                <div class="alert alert-info mt-3">
                                                    <i class="icon icon-check"></i>
                                                    Bu ürüne zaten yorum yaptınız.
                                                    @if($userReview->status->value === 'pending')
                                                        <span class="badge bg-warning">Onay bekliyor</span>
                                                    @elseif($userReview->status->value === 'approved')
                                                        <span class="badge bg-success">Yayında</span>
                                                    @else
                                                        <span class="badge bg-danger">Reddedildi</span>
                                                    @endif
                                                </div>
                                            @elseif($hasPurchased)
                                                <div>
                                                    <div class="tf-btn btn-outline-dark fw-6 btn-comment-review btn-cancel-review">
                                                        İptal
                                                    </div>
                                                    <div class="tf-btn btn-outline-dark fw-6 btn-comment-review btn-write-review">
                                                        Yorum Yaz
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-secondary mt-3">
                                                    <i class="icon icon-cart"></i>
                                                    Yorum yapabilmek için bu ürünü satın almış olmalısınız.
                                                </div>
                                            @endif
                                        @else
                                            <div class="mt-3">
                                                <a href="{{ route('login') }}" class="tf-btn btn-outline-dark fw-6">
                                                    Yorum yapmak için giriş yapın
                                                </a>
                                            </div>
                                        @endauth
                                    </div>

                                    {{-- Reviews List --}}
                                    <div class="reply-comment cancel-review-wrap">
                                        <div class="d-flex mb_24 gap-20 align-items-center justify-content-between flex-wrap">
                                            <h5>{{ str_pad($reviewsCount, 2, '0', STR_PAD_LEFT) }} Yorum</h5>
                                        </div>
                                        <div class="reply-comment-wrap">
                                            @forelse($reviews as $review)
                                                <div class="reply-comment-item">
                                                    <div class="user">
                                                        <div class="image">
                                                            <div style="width: 50px; height: 50px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #666;">
                                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6>
                                                                <span class="fw-6">{{ $review->user->name }}</span>
                                                                <span class="ms-2">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= $review->rating)
                                                                            <i class="icon icon-star" style="color: #ffc107; font-size: 12px;"></i>
                                                                        @else
                                                                            <i class="icon icon-star" style="color: #e0e0e0; font-size: 12px;"></i>
                                                                        @endif
                                                                    @endfor
                                                                </span>
                                                            </h6>
                                                            <div class="day text_black-2">{{ $review->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </div>
                                                    <h6 class="mt-2 fw-6">{{ $review->title }}</h6>
                                                    <p class="text_black-2 mt-1">{{ $review->content }}</p>
                                                </div>

                                                {{-- Admin Reply --}}
                                                @if($review->admin_reply)
                                                    <div class="reply-comment-item type-reply">
                                                        <div class="user">
                                                            <div class="image">
                                                                <div style="width: 50px; height: 50px; border-radius: 50%; background: #1a1a1a; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #fff;">
                                                                    <i class="icon icon-store"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6>
                                                                    <span class="fw-6">Mağaza Yanıtı</span>
                                                                </h6>
                                                                <div class="day text_black-2">{{ $review->admin_replied_at?->diffForHumans() }}</div>
                                                            </div>
                                                        </div>
                                                        <p class="text_black-2 mt-2">{{ $review->admin_reply }}</p>
                                                    </div>
                                                @endif
                                            @empty
                                                <div class="text-center py-5">
                                                    <i class="icon icon-comment" style="font-size: 48px; color: #ccc;"></i>
                                                    <p class="text-muted mt-3">Henüz yorum yapılmamış. İlk yorumu siz yapın!</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{-- Review Form --}}
                                    @auth
                                        @if(!$userReview && $hasPurchased)
                                            <form class="form-write-review write-review-wrap" action="{{ route('review.store', $product->slug) }}" method="POST">
                                                @csrf
                                                <div class="heading">
                                                    <h5>Yorum Yaz:</h5>
                                                    <div class="list-rating-check">
                                                        <input type="radio" id="star5" name="rating" value="5" required />
                                                        <label for="star5" title="5 Yıldız"></label>
                                                        <input type="radio" id="star4" name="rating" value="4" />
                                                        <label for="star4" title="4 Yıldız"></label>
                                                        <input type="radio" id="star3" name="rating" value="3" />
                                                        <label for="star3" title="3 Yıldız"></label>
                                                        <input type="radio" id="star2" name="rating" value="2" />
                                                        <label for="star2" title="2 Yıldız"></label>
                                                        <input type="radio" id="star1" name="rating" value="1" />
                                                        <label for="star1" title="1 Yıldız"></label>
                                                    </div>
                                                    @error('rating')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-content">
                                                    <fieldset class="box-field">
                                                        <label class="label">Yorum Başlığı</label>
                                                        <input type="text" placeholder="Yorumunuza bir başlık verin"
                                                               name="title" tabindex="2" value="{{ old('title') }}" aria-required="true"
                                                               required>
                                                        @error('title')
                                                            <span class="text-danger small">{{ $message }}</span>
                                                        @enderror
                                                    </fieldset>
                                                    <fieldset class="box-field">
                                                        <label class="label">Yorumunuz</label>
                                                        <textarea rows="4" placeholder="Ürün hakkındaki düşüncelerinizi yazın"
                                                                  name="content" tabindex="2" aria-required="true" required>{{ old('content') }}</textarea>
                                                        @error('content')
                                                            <span class="text-danger small">{{ $message }}</span>
                                                        @enderror
                                                    </fieldset>
                                                </div>
                                                <div class="button-submit">
                                                    <button class="tf-btn btn-fill animate-hover-btn" type="submit">
                                                        Yorumu Gönder
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <div class="widget-content-inner">
                                <div class="tf-page-privacy-policy">
                                    <div class="title">Teslimat ve Kargo</div>
                                    {!! str($shippingPage->content)->markdown()->sanitizeHtml() !!}
                                </div>
                            </div>
                            <div class="widget-content-inner">
                                {!! str($returnPage->content)->markdown()->sanitizeHtml() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /tabs -->
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

            $('#copy-link-btn').on('click', function() {
                const urlInput = document.getElementById('share-url-input');
                const url = urlInput.value;
                const $btn = $(this);
                const originalText = $btn.text();

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(() => {
                        showCopySuccess($btn, originalText);
                    }).catch(() => {
                        fallbackCopy(urlInput, $btn, originalText);
                    });
                } else {
                    fallbackCopy(urlInput, $btn, originalText);
                }
            });

            const fallbackCopy = (input, $btn, originalText) => {
                input.select();
                input.setSelectionRange(0, 99999);
                try {
                    document.execCommand('copy');
                    showCopySuccess($btn, originalText);
                } catch (err) {
                    showToast('Kopyalama başarısız oldu', 'error');
                }
                window.getSelection().removeAllRanges();
            };

            const showCopySuccess = ($btn, originalText) => {
                $btn.text('Kopyalandı!');
                showToast('Link kopyalandı!', 'success');
                setTimeout(() => $btn.text(originalText), 2000);
            };

            $('#add-to-favorite-btn').on('click', async function() {
                @auth
                const $btn = $(this);
                const $icon = $btn.find('i');
                const slug = $btn.data('product-slug');

                $btn.prop('disabled', true);

                try {
                    const {data} = await axios.post('{{ route("account.favorite.toggle", ["slug" => $product->slug]) }}');

                    if (data.success) {
                        if (data.data.is_favorited) {
                            $btn.addClass('favorited');
                            $icon.removeClass('icon-heart').addClass('icon-heart-full');
                            showToast('Ürün favorilere eklendi', 'success');
                        } else {
                            $btn.removeClass('favorited');
                            $icon.removeClass('icon-heart-full').addClass('icon-heart');
                            showToast('Ürün favorilerden çıkarıldı', 'success');
                        }

                        $('.favorite-count').text(data.data.favorites_count);
                    }
                } catch (error) {
                    console.error('Favorite toggle error:', error);
                    showToast('Bir hata oluştu', 'error');
                } finally {
                    $btn.prop('disabled', false);
                }
                @else
                window.location.href = '{{ route("login") }}';
                @endauth
            });

            window.showToast = showToast;
            window.updateCartCount = updateCartCount;
        });

        function copyAndOpen(platform) {
            const url = document.getElementById('share-url-input').value;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(() => {
                    if (window.showToast) {
                        window.showToast('Link kopyalandı! ' + (platform === 'instagram' ? 'Instagram' : 'TikTok') + '\'da paylaşabilirsiniz.', 'success');
                    }
                });
            } else {
                const input = document.getElementById('share-url-input');
                input.select();
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                if (window.showToast) {
                    window.showToast('Link kopyalandı! ' + (platform === 'instagram' ? 'Instagram' : 'TikTok') + '\'da paylaşabilirsiniz.', 'success');
                }
            }
        }
    </script>

@endpush
