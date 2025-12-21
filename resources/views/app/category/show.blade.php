@extends('app.layouts.main')
@section('title', $category?->name)
@push('css')
    <style>
        .wishlist-toggle.favorited .icon-heart {
            color: #e74c3c !important;
        }
        .wishlist-toggle.favorited .icon-heart::before {
            content: "\e92f";
            font-family: 'icomoon', sans-serif !important;
        }
        .wishlist-toggle.loading {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
@endpush
@section('content')
    <!-- page-title -->
    <div class="tf-page-title">
        <div class="container-full">
            <div class="heading text-center">{{$category?->name ?? ''}}</div>
            <p class="text-center text-2 text_black-2 mt_5">{{$category?->description ?? 'Ata Silver'}}</p>
        </div>
    </div>
    <!-- /page-title -->
    <!-- Section Product -->
    <section class="flat-spacing-2">
        <div class="container">
            <div class="tf-shop-control grid-3 align-items-center">
                <div class="tf-control-filter">
                    <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                       class="tf-btn-filter"><span class="icon icon-filter"></span><span class="text">Filtre</span></a>
                </div>
                <ul class="tf-control-layout d-flex justify-content-center">
                    <li class="tf-view-layout-switch sw-layout-list list-layout" data-value-layout="list">
                        <div class="item"><span class="icon icon-list"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-2" data-value-layout="tf-col-2">
                        <div class="item"><span class="icon icon-grid-2"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-3" data-value-layout="tf-col-3">
                        <div class="item"><span class="icon icon-grid-3"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-4 active" data-value-layout="tf-col-4">
                        <div class="item"><span class="icon icon-grid-4"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-5" data-value-layout="tf-col-5">
                        <div class="item"><span class="icon icon-grid-5"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-6" data-value-layout="tf-col-6">
                        <div class="item"><span class="icon icon-grid-6"></span></div>
                    </li>
                </ul>
                <div class="tf-control-sorting d-flex justify-content-end">
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">{{ match(request('sort')) {
                                'featured' => 'Öne Çıkanlar',
                                'best-selling' => 'En Çok Satanlar',
                                'a-z' => 'Alfabetik, A-Z',
                                'z-a' => 'Alfabetik, Z-A',
                                'price-low-high' => 'Fiyata Göre, Artan',
                                'price-high-low' => 'Fiyata Göre, Azalan',
                                default => 'Sırala'
                            } }}</span>
                            <span class="icon icon-arrow-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div
                                class="select-item {{ !request('sort') || request('sort') === 'featured' ? 'active' : '' }}"
                                data-sort-value="featured">
                                <span class="text-value-item">Öne Çıkanlar</span>
                            </div>
                            <div class="select-item {{ request('sort') === 'best-selling' ? 'active' : '' }}"
                                 data-sort-value="best-selling">
                                <span class="text-value-item">En Çok Satanlar</span>
                            </div>
                            <div class="select-item {{ request('sort') === 'newest' ? 'active' : '' }}"
                                 data-sort-value="newest">
                                <span class="text-value-item">Yeni Çıkanlar</span>
                            </div>
                            <div class="select-item {{ request('sort') === 'a-z' ? 'active' : '' }}"
                                 data-sort-value="a-z">
                                <span class="text-value-item">Alfabetik, A-Z</span>
                            </div>
                            <div class="select-item {{ request('sort') === 'z-a' ? 'active' : '' }}"
                                 data-sort-value="z-a">
                                <span class="text-value-item">Alfabetik, Z-A</span>
                            </div>
                            <div class="select-item {{ request('sort') === 'price-low-high' ? 'active' : '' }}"
                                 data-sort-value="price-low-high">
                                <span class="text-value-item">Fiyata Göre, Artan</span>
                            </div>
                            <div class="select-item {{ request('sort') === 'price-high-low' ? 'active' : '' }}"
                                 data-sort-value="price-high-low">
                                <span class="text-value-item">Fiyata Göre, Azalan</span>
                            </div>
                        </div>
                    </div>
                    @if(request('sort'))
                        <a href="{{ route('category.show', $category->slug) }}"
                           class="ms-2 tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">Temizle</a>
                    @endif
                </div>
            </div>
            <div class="wrapper-control-shop">
                <div class="meta-filter-shop">
                    <div id="product-count-grid" class="count-text"></div>
                    <div id="product-count-list" class="count-text"></div>
                    <div id="applied-filters"></div>
                    <button id="remove-all" class="remove-all-filters" style="display: none;">Temizle<i
                            class="icon icon-close"></i></button>
                </div>
                <div class="wrapper-control-shop">
                    {{-- Ürün Listesi - LIST Layout --}}
                    <div class="tf-list-layout wrapper-shop" id="listLayout">
                        @foreach($products as $product)
                            <div class="card-product list-layout">
                                <div class="card-product-wrapper">
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-img">
                                        <img class="lazyload {{$product->gett}}"
                                             data-src="{{ $product->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png') }}"
                                             src="{{ $product->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png') }}"
                                             alt="{{ $product->name }}">
                                        @if($product->getMedia('products')->count() > 1)
                                            <img class="lazyload img-hover"
                                                 data-src="{{ $product->getFirstMediaUrl('products', 'thumb') }}"
                                                 src="{{ $product->getFirstMediaUrl('products', 'thumb') }}"
                                                 alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="card-product-info">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                       class="title link">{{ $product->name }}</a>
                                    @if($product->has_discount)
                                        <div class="d-flex">
                                            <span class="price old-price"
                                                  style="text-decoration: line-through; color: #999;">{{ number_format($product->display_original_price, 2) }} ₺</span>
                                            <span class="price current-price"
                                                  style="color: #e74c3c; font-weight: bold;">{{ number_format($product->display_price, 2) }} ₺</span>
                                        </div>
                                    @else
                                        <span class="price current-price">{{ number_format($product->display_price, 2) }} ₺</span>
                                    @endif
                                    <p class="description">{{ \Illuminate\Support\Str::limit($product->short_description, 150) }}</p>
                                    <div class="list-product-btn">
                                        <a href="javascript:void(0);"
                                           data-id="{{ $product->slug }}"
                                           class="box-icon quick-add style-3 hover-tooltip">
                                            <span class="icon icon-bag"></span><span class="tooltip">Hızlı Ekle</span>
                                        </a>
                                        <a href="javascript:void(0);"
                                           data-slug="{{ $product->slug }}"
                                           class="box-icon wishlist-toggle style-3 hover-tooltip {{ auth()->check() && auth()->user()->hasFavorited($product) ? 'favorited' : '' }}">
                                            <span class="icon icon-heart"></span> <span
                                                class="tooltip">{{ auth()->check() && auth()->user()->hasFavorited($product) ? 'Favorilerden Çıkar' : 'Favorilere Ekle' }}</span>
                                        </a>
                                        <a href="javascript:void(0);"
                                           data-id="{{ $product->slug }}"
                                           class="box-icon quickview style-3 hover-tooltip">
                                            <span class="icon icon-view"></span><span class="tooltip">Hızlı Bakış</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                    {{-- Ürün Listesi - GRID Layout --}}
                    <div class="tf-grid-layout wrapper-shop tf-col-4" id="gridLayout">
                        @foreach($products as $product)
                            <div class="card-product grid">
                                <div class="card-product-wrapper">
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-img">
                                        <img class="lazyload img-product"
                                             data-src="{{ $product->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png') }}"
                                             src="{{ $product->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png') }}"
                                             alt="{{ $product->name }}">
                                        @if($product->getMedia('images')->count() > 1)
                                            @foreach($product->getMedia('images')->take(2) as $image)
                                                <img class="lazyload img-hover"
                                                     data-src="{{ $image->getUrl('large') }}"
                                                     src="{{ $image->getUrl('large') }}"
                                                     alt="{{ $product->name }}">
                                            @endforeach
                                        @endif
                                    </a>
                                    <div class="list-product-btn absolute-2">
                                        <a href="javascript:void(0);"
                                           data-id="{{ $product->slug }}"
                                           class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span><span class="tooltip">Hızlı Ekle</span>
                                        </a>
                                        <a href="javascript:void(0);"
                                           data-slug="{{ $product->slug }}"
                                           class="box-icon bg_white wishlist-toggle {{ auth()->check() && auth()->user()->hasFavorited($product) ? 'favorited' : '' }}">
                                            <span class="icon icon-heart"></span><span
                                                class="tooltip">{{ auth()->check() && auth()->user()->hasFavorited($product) ? 'Favorilerden Çıkar' : 'Favorilere Ekle' }}</span>
                                        </a>
                                        <a href="javascript:void(0);"
                                           data-id="{{ $product->slug }}"
                                           class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span><span class="tooltip">Hızlı Bakış</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                       class="title link">{{ $product->name }}</a>
                                    @if($product->has_discount)
                                        <div class="d-flex">
                                            <span class="price old-price"
                                                  style="text-decoration: line-through; color: #999;">{{ number_format($product->display_original_price, 2) }} ₺</span>
                                            <span class="price current-price ms-2"
                                                  style="color: #e74c3c; font-weight: bold;">{{ number_format($product->display_price, 2) }} ₺</span>
                                        </div>
                                    @else
                                        <span class="price current-price">{{ number_format($product->display_price, 2) }} ₺</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Section Product -->
    <!-- Filter -->
    <div class="offcanvas offcanvas-start canvas-filter" id="filterShop">
        <div class="canvas-wrapper">
            <header class="canvas-header">
                <div class="filter-icon">
                    <span class="icon icon-filter"></span>
                    <span>Filtre</span>
                </div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body">
                <form action="{{ route('category.show', $category->slug) }}" method="GET" id="facet-filter-form"
                      class="facet-filter-form">
                    {{-- Mevcut sort parametresini koru --}}
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    {{-- Fiyat Aralığı --}}
                    <div class="widget-facet">
                        <div class="facet-title" data-bs-target="#price" data-bs-toggle="collapse" aria-expanded="true"
                             aria-controls="price">
                            <span>Fiyat Aralığı</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="price" class="collapse show">
                            <div class="widget-price filter-price">
                                <div class="price-val-range" id="price-value-range"
                                     data-min="0"
                                     data-max="100000"
                                     data-current-min="{{ request('price_min', 0) }}"
                                     data-current-max="{{ request('price_max', 100000) }}"></div>
                                <div class="box-title-price">
                                    <span class="title-price">Fiyat:</span>
                                    <div class="caption-price">
                                        <div class="price-val" id="price-min-value"
                                             data-currency="₺">{{ request('price_min', 0) }}</div>
                                        <span>-</span>
                                        <div class="price-val" id="price-max-value"
                                             data-currency="₺">{{ request('price_max', 100000) }}</div>
                                    </div>
                                </div>
                                <input type="hidden" name="price_min" id="price-min-input"
                                       value="{{ request('price_min') }}">
                                <input type="hidden" name="price_max" id="price-max-input"
                                       value="{{ request('price_max') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Alt Kategoriler --}}
                    @if($category->children->count() > 0)
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#subcategories" data-bs-toggle="collapse"
                                 aria-expanded="true"
                                 aria-controls="subcategories">
                                <span>Alt Kategoriler</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="subcategories" class="collapse show">
                                <ul class="tf-filter-group current-scrollbar">
                                    @foreach($category->children as $child)
                                        <li class="list-item d-flex gap-12 align-items-center">
                                            <input type="checkbox" name="subcategory[]" class="tf-check"
                                                   value="{{ $child->id }}" id="subcat-{{ $child->id }}"
                                                {{ in_array($child->id, (array) request('subcategory', [])) ? 'checked' : '' }}>
                                            <label for="subcat-{{ $child->id }}" class="label">
                                                <span>{{ $child->name }}</span>
                                                <span
                                                    class="text-muted">({{ $child->products()->active()->count() }})</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Ürün Durumu --}}
                    <div class="widget-facet">
                        <div class="facet-title" data-bs-target="#status" data-bs-toggle="collapse" aria-expanded="true"
                             aria-controls="status">
                            <span>Ürün Durumu</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="status" class="collapse show">
                            <ul class="tf-filter-group current-scrollbar">
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="checkbox" name="on_sale" class="tf-check" value="1" id="on_sale"
                                        {{ request('on_sale') ? 'checked' : '' }}>
                                    <label for="on_sale" class="label">
                                        <span>İndirimli Ürünler</span>
                                    </label>
                                </li>
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="checkbox" name="is_new" class="tf-check" value="1" id="is_new"
                                        {{ request('is_new') ? 'checked' : '' }}>
                                    <label for="is_new" class="label">
                                        <span>Yeni Ürünler</span>
                                    </label>
                                </li>
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="checkbox" name="is_featured" class="tf-check" value="1"
                                           id="is_featured_filter"
                                        {{ request('is_featured') ? 'checked' : '' }}>
                                    <label for="is_featured_filter" class="label">
                                        <span>Öne Çıkan Ürünler</span>
                                    </label>
                                </li>
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="checkbox" name="is_best_seller" class="tf-check" value="1"
                                           id="is_best_seller"
                                        {{ request('is_best_seller') ? 'checked' : '' }}>
                                    <label for="is_best_seller" class="label">
                                        <span>Çok Satanlar</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Filtre Butonları --}}
                    <div class="widget-facet mt-4">
                        <button type="submit" class="tf-btn w-100 btn-fill animate-hover-btn justify-content-center">
                            <span>Filtrele</span>
                        </button>
                        <a href="{{ route('category.show', $category->slug) }}"
                           class="tf-btn w-100 btn-outline mt-2 justify-content-center">
                            <span>Filtreleri Temizle</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Filter -->

@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('front/js/nouislider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/js/shop.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.tf-dropdown-sort .select-item', function (e) {
                e.preventDefault();

                const sortValue = $(this).data('sort-value');
                const url = new URL(window.location.href);

                if (sortValue) {
                    url.searchParams.set('sort', sortValue);
                } else {
                    url.searchParams.delete('sort');
                }

                url.searchParams.delete('page');

                window.location.href = url.toString();
            });

            let currentProductData = {
                quick_add: null,
                quick_view: null
            };

            function formatPrice(price) {
                return new Intl.NumberFormat('tr-TR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(price) + ' ₺';
            }

            function formatPriceDisplay(price, originalPrice, hasDiscount) {
                if (hasDiscount && originalPrice) {
                    return `<span style="text-decoration: line-through; color: #999; margin-right: 8px;">${formatPrice(originalPrice)}</span><span style="color: #e74c3c; font-weight: bold;">${formatPrice(price)}</span>`;
                }
                return formatPrice(price);
            }

            function updateTotalPrice(modalType) {
                const $modal = modalType === 'qv' ? $('#quick_view') : $('#quick_add');
                const productData = currentProductData[modalType === 'qv' ? 'quick_view' : 'quick_add'];

                if (!productData) return;

                const quantity = parseInt($modal.find('.wg-quantity input').val()) || 1;
                const unitPrice = productData.currentPrice || productData.raw_price;
                const totalPrice = unitPrice * quantity;

                $modal.find('.tf-qty-price').html(formatPrice(totalPrice));
            }

            function findMatchingVariation(productData, modalType) {
                if (!productData.variations || productData.variations.length === 0) {
                    return {
                        price: productData.raw_price,
                        originalPrice: productData.raw_original_price,
                        hasDiscount: productData.has_discount,
                        variationId: null,
                        stockQuantity: 999
                    };
                }

                const $modal = modalType === 'qv' ? $('#quick_view') : $('#quick_add');
                const selected = {};

                $modal.find('.variant-picker-item').each(function () {
                    const optionName = $(this).find('.variant-picker-label').text().split(':')[0].trim();
                    const selectedValue = $(this).find('input:checked').val();
                    if (selectedValue) {
                        selected[optionName.toLowerCase()] = selectedValue.toLowerCase();
                    }
                });

                for (const variation of productData.variations) {
                    if (!variation.options) continue;

                    let isMatch = true;
                    for (const opt of variation.options) {
                        const optName = opt.type_name?.toLowerCase() || '';
                        const optValue = opt.option_name?.toLowerCase() || '';
                        if (selected[optName] && selected[optName] !== optValue) {
                            isMatch = false;
                            break;
                        }
                    }

                    if (isMatch) {
                        return {
                            price: parseFloat(variation.effective_price || variation.selling_price || productData.raw_price),
                            originalPrice: variation.has_discount ? parseFloat(variation.selling_price) : null,
                            hasDiscount: variation.has_discount,
                            variationId: variation.id,
                            stockQuantity: variation.stock_quantity || 0
                        };
                    }
                }

                return {
                    price: productData.raw_price,
                    originalPrice: productData.raw_original_price,
                    hasDiscount: productData.has_discount,
                    variationId: null,
                    stockQuantity: 0
                };
            }

            function updateButtonState($modal, stockQuantity, price) {
                const $addToCartBtn = $modal.find('.btn-add-to-cart');
                const $badges = $modal.find('.tf-product-info-badges');
                const hasStock = stockQuantity > 0;

                $badges.find('.stock-badge').remove();

                if (hasStock) {
                    $addToCartBtn
                        .removeClass('disabled btn-outline')
                        .addClass('btn-fill')
                        .css({'pointer-events': 'auto', 'opacity': '1'})
                        .html(`<span>Sepete Ekle -&nbsp;</span><span class="tf-qty-price">${formatPrice(price)}</span>`);
                } else {
                    $addToCartBtn
                        .removeClass('btn-fill')
                        .addClass('disabled btn-outline')
                        .css({'pointer-events': 'none', 'opacity': '0.6'})
                        .html('<span>Stok Tükendi</span>');

                    $badges.append('<div class="badge bg-danger-subtle text-danger stock-badge">Stok Tükendi</div>');
                }

                $modal.data('has-stock', hasStock);
            }

            function generateVariantHTML(variants, modalType, productData) {
                let html = '';

                let currentSelections = {};
                variants.forEach(variant => {
                    currentSelections[variant.option.toLowerCase()] = variant.selected?.toLowerCase();
                });

                function checkOptionStock(typeName, optionValue, allVariants) {
                    if (!productData || !productData.variations) return true;

                    for (const variation of productData.variations) {
                        if (!variation.options || variation.stock_quantity <= 0) continue;

                        let hasTargetOption = false;
                        let matchesOtherSelections = true;

                        for (const opt of variation.options) {
                            const optTypeName = opt.type_name?.toLowerCase() || '';
                            const optValue = opt.option_name?.toLowerCase() || '';

                            if (optTypeName === typeName.toLowerCase()) {
                                if (optValue === optionValue.toLowerCase()) {
                                    hasTargetOption = true;
                                } else {
                                    hasTargetOption = false;
                                    break;
                                }
                            } else {
                                const currentSelection = currentSelections[optTypeName];
                                if (currentSelection && optValue !== currentSelection) {
                                    matchesOtherSelections = false;
                                }
                            }
                        }

                        if (hasTargetOption && matchesOtherSelections) {
                            return true;
                        }
                    }
                    return false;
                }

                variants.forEach((variant, index) => {
                    let optionsHtml = '';

                    const colorMap = {
                        'siyah': '#000000',
                        'beyaz': '#FFFFFF',
                        'mavi': '#2196F3',
                        'kırmızı': '#F44336',
                        'yeşil': '#4CAF50',
                        'sarı': '#FFEB3B',
                        'mor': '#9C27B0',
                        'pembe': '#E91E63',
                        'turuncu': '#FF9800',
                        'gri': '#9E9E9E',
                        'kahverengi': '#795548',
                        'lacivert': '#1A237E',
                        'bej': '#F5F5DC',
                        'altın': '#FFD700',
                        'gümüş': '#C0C0C0',
                        'black': '#000000',
                        'white': '#FFFFFF',
                        'blue': '#2196F3',
                        'red': '#F44336',
                        'green': '#4CAF50',
                        'yellow': '#FFEB3B',
                        'purple': '#9C27B0',
                        'pink': '#E91E63',
                        'orange': '#FF9800',
                        'gray': '#9E9E9E',
                        'brown': '#795548',
                        'gold': '#FFD700',
                        'silver': '#C0C0C0'
                    };

                    function getColorCode(colorName) {
                        return colorMap[colorName.toLowerCase()] || colorName;
                    }

                    variant.values.forEach((valueObj, vIndex) => {
                        // valueObj artık {name: 'Mavi', image: 'url'} şeklinde
                        let valueName = typeof valueObj === 'object' ? valueObj.name : valueObj;
                        let valueImage = typeof valueObj === 'object' ? (valueObj.image || '') : '';
                        let uniqueId = `val-${modalType}-${index}-${vIndex}`;
                        let checked = valueName === variant.selected ? 'checked' : '';
                        let colorCode = getColorCode(valueName);
                        let hasStock = checkOptionStock(variant.option, valueName, variants);
                        let disabledClass = hasStock ? '' : 'disabled';
                        let disabledAttr = hasStock ? '' : 'disabled';
                        let disabledStyle = hasStock ? '' : 'style="opacity: 0.4; pointer-events: none; cursor: not-allowed;"';
                        let outOfStockText = hasStock ? '' : ' (Mevcut Değil)';

                        if (variant.option.toLowerCase() === 'color' || variant.option.toLowerCase() === 'renk') {
                            optionsHtml += `
                        <input id="${uniqueId}" type="radio" name="${modalType}_${variant.option}" value="${valueName}" data-image="${valueImage}" ${checked} ${disabledAttr}>
                        <label class="hover-tooltip radius-60 ${disabledClass}" for="${uniqueId}" data-value="${valueName}" ${disabledStyle}>
                            <span class="btn-checkbox" style="background-color: ${colorCode};"></span>
                            <span class="tooltip">${valueName}${outOfStockText}</span>
                        </label>
                    `;
                        } else {
                            optionsHtml += `
                        <input type="radio" name="${modalType}_${variant.option}" id="${uniqueId}" value="${valueName}" data-image="${valueImage}" ${checked} ${disabledAttr}>
                        <label class="style-text ${disabledClass}" for="${uniqueId}" data-value="${valueName}" ${disabledStyle}>
                            <p>${valueName}${outOfStockText}</p>
                        </label>
                    `;
                        }
                    });

                    html += `
                <div class="variant-picker-item">
                    <div class="variant-picker-label">
                        ${variant.option}: <span class="fw-6 variant-picker-label-value">${variant.selected}</span>
                    </div>
                    <div class="variant-picker-values">
                        ${optionsHtml}
                    </div>
                </div>
            `;
                });
                return html;
            }

            $(document).on('click', '.quickview, .quick-add', function (e) {
                e.preventDefault();

                let btn = $(this);
                let slug = btn.data('id');
                let isQuickView = btn.hasClass('quickview');
                let targetModalId = isQuickView ? '#quick_view' : '#quick_add';
                let $modal = $(targetModalId);
                let modalType = isQuickView ? 'qv' : 'qa';
                let dataKey = isQuickView ? 'quick_view' : 'quick_add';

                btn.addClass('loading');

                axios.get('/quick-view/' + slug)
                    .then(function (response) {
                        let product = response.data.data;
                        if (product.variations) {
                            product.variations.forEach(v => {

                            });
                        }

                        currentProductData[dataKey] = product;
                        currentProductData[dataKey].currentPrice = product.raw_price;

                        $modal.find('.wg-quantity input').val(1);

                        $modal.find('.tf-product-info-title a, .content a').text(product.name).attr('href', product.url);
                        $modal.find('.btn-view-full-details').attr('href', product.url);

                        let priceHtml = formatPriceDisplay(product.raw_price, product.raw_original_price, product.has_discount);
                        $modal.find('.price-container').html(priceHtml);
                        $modal.find('.tf-product-description p').text(product.description);
                        $modal.find('.tf-qty-price').html(formatPrice(product.raw_price));

                        $modal.data('product-id', product.id);
                        $modal.data('product-slug', slug);
                        $modal.data('variation-id', product.default_variation_id || null);

                        let variantContainer = $modal.find('.tf-product-info-variant-picker');
                        variantContainer.html(generateVariantHTML(product.variants, modalType, product));

                        const matchedVariation = findMatchingVariation(product, modalType);
                        updateButtonState($modal, matchedVariation.stockQuantity, matchedVariation.price);
                        $modal.data('variation-id', matchedVariation.variationId);

                        if (isQuickView) {
                            let swiperWrapper = $modal.find('.swiper-wrapper');
                            swiperWrapper.empty();

                            product.images.forEach(imgUrl => {
                                swiperWrapper.append(`
                            <div class="swiper-slide">
                                <div class="item">
                                    <img src="${imgUrl}" alt="${product.name}" style="width:100%; object-fit:cover;">
                                </div>
                            </div>
                        `);
                            });

                            setTimeout(() => {
                                const swiperEl = $modal.find('.tf-single-slide')[0];
                                if (swiperEl && swiperEl.swiper) {
                                    swiperEl.swiper.update();
                                    swiperEl.swiper.slideTo(0);
                                }
                            }, 100);
                        } else {
                            if (product.images.length > 0) {
                                $modal.find('.image img').attr('src', product.images[0]);
                            }
                        }

                        var myModal = new bootstrap.Modal(document.getElementById(isQuickView ? 'quick_view' : 'quick_add'));
                        myModal.show();
                    })
                    .catch(function (error) {
                        console.error("Hata:", error);
                        alert("Ürün detayları yüklenirken bir hata oluştu.");
                    })
                    .finally(function () {
                        btn.removeClass('loading');
                    });
            });

            $(document).on('change', '.variant-picker-values input', function () {
                let selectedValue = $(this).val();
                let selectedImage = $(this).data('image');
                let $modal = $(this).closest('.modal');
                let modalType = $modal.attr('id') === 'quick_view' ? 'qv' : 'qa';
                let dataKey = $modal.attr('id') === 'quick_view' ? 'quick_view' : 'quick_add';

                $(this).closest('.variant-picker-item').find('.variant-picker-label-value').text(selectedValue);

                if (selectedImage) {
                    if (modalType === 'qv') {
                        $modal.find('.swiper-slide:first-child .item img').attr('src', selectedImage);
                        const swiperEl = $modal.find('.tf-single-slide')[0];
                        if (swiperEl && swiperEl.swiper) {
                            swiperEl.swiper.slideTo(0);
                        }
                    } else {
                        $modal.find('.image img').attr('src', selectedImage);
                    }
                }

                const productData = currentProductData[dataKey];
                if (productData) {
                    let currentSelections = {};
                    $modal.find('.variant-picker-item').each(function() {
                        let optionName = $(this).find('.variant-picker-label').text().split(':')[0].trim().toLowerCase();
                        let selectedVal = $(this).find('input:checked').val();
                        if (selectedVal) {
                            currentSelections[optionName] = selectedVal.toLowerCase();
                        }
                    });

                    $modal.find('.variant-picker-item').each(function() {
                        let typeName = $(this).find('.variant-picker-label').text().split(':')[0].trim();

                        $(this).find('.variant-picker-values input').each(function() {
                            let optionValue = $(this).val();
                            let $label = $(this).next('label');

                            let hasStock = checkCombinationStock(productData, typeName, optionValue, currentSelections);

                            if (hasStock) {
                                $(this).prop('disabled', false);
                                $label.removeClass('disabled').css({'opacity': '1', 'pointer-events': 'auto', 'cursor': 'pointer'});
                                let labelText = $label.find('p').length ? $label.find('p').text() : $label.find('.tooltip').text();
                                if (labelText && labelText.includes('(Mevcut Değil)')) {
                                    if ($label.find('p').length) {
                                        $label.find('p').text(labelText.replace(' (Mevcut Değil)', ''));
                                    } else {
                                        $label.find('.tooltip').text(labelText.replace(' (Mevcut Değil)', ''));
                                    }
                                }
                            } else {
                                $(this).prop('disabled', true);
                                $label.addClass('disabled').css({'opacity': '0.4', 'pointer-events': 'none', 'cursor': 'not-allowed'});
                                let labelText = $label.find('p').length ? $label.find('p').text() : $label.find('.tooltip').text();
                                if (labelText && !labelText.includes('(Mevcut Değil)')) {
                                    if ($label.find('p').length) {
                                        $label.find('p').text(labelText + ' (Mevcut Değil)');
                                    } else {
                                        $label.find('.tooltip').text(labelText + ' (Mevcut Değil)');
                                    }
                                }
                            }
                        });
                    });

                    const matchedVariation = findMatchingVariation(productData, modalType);
                    productData.currentPrice = matchedVariation.price;

                    $modal.data('variation-id', matchedVariation.variationId);

                    let priceHtml = formatPriceDisplay(matchedVariation.price, matchedVariation.originalPrice, matchedVariation.hasDiscount);
                    $modal.find('.price-container').html(priceHtml);
                    updateButtonState($modal, matchedVariation.stockQuantity, matchedVariation.price);
                    updateTotalPrice(modalType);
                }
            });

            function checkCombinationStock(productData, typeName, optionValue, currentSelections) {
                if (!productData || !productData.variations) return true;

                for (const variation of productData.variations) {
                    if (!variation.options || variation.stock_quantity <= 0) continue;

                    let hasTargetOption = false;
                    let matchesOtherSelections = true;

                    for (const opt of variation.options) {
                        const optTypeName = opt.type_name?.toLowerCase() || '';
                        const optValue = opt.option_name?.toLowerCase() || '';

                        if (optTypeName === typeName.toLowerCase()) {
                            if (optValue === optionValue.toLowerCase()) {
                                hasTargetOption = true;
                            } else {
                                hasTargetOption = false;
                                break;
                            }
                        } else {
                            const currentSelection = currentSelections[optTypeName];
                            if (currentSelection && optValue !== currentSelection) {
                                matchesOtherSelections = false;
                            }
                        }
                    }

                    if (hasTargetOption && matchesOtherSelections) {
                        return true;
                    }
                }
                return false;
            }

            $('#quick_view, #quick_add').on('shown.bs.modal', function() {
                var $modal = $(this);
                $modal.find('.plus-btn').off('click');
                $modal.find('.minus-btn').off('click');
            });

            $(document).on('click', '#quick_view .plus-btn, #quick_add .plus-btn', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let $input = $(this).siblings('input');
                let currentVal = parseInt($input.val()) || 1;
                $input.val(currentVal + 1);

                let $modal = $(this).closest('.modal');
                let modalType = $modal.attr('id') === 'quick_view' ? 'qv' : 'qa';
                updateTotalPrice(modalType);
                return false;
            });

            $(document).on('click', '#quick_view .minus-btn, #quick_add .minus-btn', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let $input = $(this).siblings('input');
                let currentVal = parseInt($input.val()) || 1;
                if (currentVal > 1) {
                    $input.val(currentVal - 1);
                }

                let $modal = $(this).closest('.modal');
                let modalType = $modal.attr('id') === 'quick_view' ? 'qv' : 'qa';
                updateTotalPrice(modalType);
                return false;
            });

            $(document).on('change keyup', '.wg-quantity input', function () {
                let currentVal = parseInt($(this).val()) || 1;
                if (currentVal < 1) {
                    $(this).val(1);
                }

                let $modal = $(this).closest('.modal');
                let modalType = $modal.attr('id') === 'quick_view' ? 'qv' : 'qa';
                updateTotalPrice(modalType);
            });

            $(document).on('click', '.btn-add-to-cart', function (e) {
                e.preventDefault();

                let $btn = $(this);
                let $modal = $btn.closest('.modal');
                let dataKey = $modal.attr('id') === 'quick_view' ? 'quick_view' : 'quick_add';
                let productData = currentProductData[dataKey];

                if (!productData) {
                    alert('Ürün bilgisi bulunamadı.');
                    return;
                }

                let quantity = parseInt($modal.find('.wg-quantity input').val()) || 1;
                let variationId = $modal.data('variation-id');
                let productId = productData.id;

                $btn.addClass('loading').prop('disabled', true);
                let originalText = $btn.html();
                $btn.html('<span>Ekleniyor...</span>');

                axios.post('{{ route("cart.store") }}', {
                    product_id: productId,
                    variation_id: variationId,
                    quantity: quantity
                })
                    .then(function (response) {
                        if (response.data.success) {
                            if (typeof refreshMiniCart === 'function') {
                                refreshMiniCart();
                            } else {
                                $('.cart-count').text(response.data.data.cart_count);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: response.data.message || 'Ürün sepete eklendi.',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            bootstrap.Modal.getInstance($modal[0])?.hide();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: response.data.message || 'Bir hata oluştu.'
                            });
                        }
                    })
                    .catch(function (error) {
                        console.error('Sepete ekleme hatası:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: error.response?.data?.message || 'Ürün sepete eklenirken bir hata oluştu.'
                        });
                    })
                    .finally(function () {
                        $btn.removeClass('loading').prop('disabled', false);
                        $btn.html(originalText);
                    });
            });

            $(document).on('click', '.wishlist-toggle', function (e) {
                e.preventDefault();

                let $btn = $(this);
                let slug = $btn.data('slug');

                if (!slug || $btn.hasClass('loading')) return;

                $btn.addClass('loading');

                axios.post('{{ route("account.favorite.toggle", ":slug") }}'.replace(':slug', slug))
                    .then(response => {
                        if (!response.data.success) return;

                        $('.favorites-count').text(response.data.data.favorites_count);

                        let isFavorited = response.data.data.is_favorited;
                        let $tooltip = $btn.find('.tooltip');

                        $btn.toggleClass('favorited', isFavorited);

                        if ($tooltip.length) {
                            $tooltip.text(isFavorited ? 'Favorilerden Çıkar' : 'Favorilere Ekle');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı!',
                            text: response.data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    })
                    .catch(error => {
                        if (error.response?.status === 401) {
                            window.location.href = '{{ route("login") }}';
                            return;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: error.response?.data?.message || 'Bir hata oluştu.'
                        });
                    })
                    .finally(() => {
                        $btn.removeClass('loading');
                    });
            });

        });
    </script>
@endpush

