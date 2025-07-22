@extends('app.layouts.main')
@section('title', $category?->name)
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
                            <span class="text-sort-value">Featured</span>
                            <span class="icon icon-arrow-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active">
                                <span class="text-value-item">Featured</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Best selling</span>
                            </div>
                            <div class="select-item" data-sort-value="a-z">
                                <span class="text-value-item">Alphabetically, A-Z</span>
                            </div>
                            <div class="select-item" data-sort-value="z-a">
                                <span class="text-value-item">Alphabetically, Z-A</span>
                            </div>
                            <div class="select-item" data-sort-value="price-low-high">
                                <span class="text-value-item">Price, low to high</span>
                            </div>
                            <div class="select-item" data-sort-value="price-high-low">
                                <span class="text-value-item">Price, high to low</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Date, old to new</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Date, new to old</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper-control-shop">
                <div class="meta-filter-shop">
                    <div id="product-count-grid" class="count-text"></div>
                    <div id="product-count-list" class="count-text"></div>
                    <div id="applied-filters"></div>
                    <button id="remove-all" class="remove-all-filters" style="display: none;">Remove All <i
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
                                             data-src="{{ $product->getFirstMediaUrl('products', 'thumb') ?: asset('images/placeholder.png') }}"
                                             src="{{ $product->getFirstMediaUrl('products', 'thumb') ?: asset('images/placeholder.png') }}"
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
                                    <span
                                        class="price current-price">{{ number_format($product->base_price, 2) }} ₺</span>
                                    <p class="description">{{ \Illuminate\Support\Str::limit($product->short_description, 150) }}</p>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                           class="box-icon quick-add style-3 hover-tooltip">
                                            <span class="icon icon-bag"></span><span class="tooltip">Hızlı Ekle</span>
                                        </a>
                                        <a href="#" class="box-icon wishlist style-3 hover-tooltip">
                                            <span class="icon icon-heart"></span> <span
                                                class="tooltip">Favorilere Ekle</span>
                                        </a>
                                        <a href="#quick_view"
                                           data-bs-toggle="modal"
                                           data-bs-target="#quick_view"
                                           data-id="{{ $product->hashid() }}"
                                           class="box-icon quickview style-3 hover-tooltip"
                                        >
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
                                             data-src="{{ $product->getFirstMediaUrl('products', 'thumb') ?: asset('images/placeholder.png') }}"
                                             src="{{ $product->getFirstMediaUrl('products', 'thumb') ?: asset('images/placeholder.png') }}"
                                             alt="{{ $product->name }}">
                                        @if($product->getMedia('products')->count() > 1)
                                            <img class="lazyload img-hover"
                                                 data-src="{{ $product->getMedia('products')[1]->getUrl('thumb') }}"
                                                 src="{{ $product->getMedia('products')[1]->getUrl('thumb') }}"
                                                 alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    <div class="list-product-btn absolute-2">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                           class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span><span class="tooltip">Hızlı Ekle</span>
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span><span
                                                class="tooltip">Favorilere Ekle</span><span
                                                class="icon icon-delete"></span>
                                        </a>
                                        <a href="#quick_view"
                                           data-bs-toggle="modal"
                                           data-bs-target="#quick_view"
                                           data-id="{{ $product->hashid() }}"
                                           class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span><span class="tooltip">Hızlı Bakış</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                       class="title link">{{ $product->name }}</a>
                                    <span
                                        class="price current-price">{{ number_format($product->base_price, 2) }} ₺</span>
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
                <form action="#" id="facet-filter-form" class="facet-filter-form">
                    <div class="widget-facet">
                        <div class="facet-title" data-bs-target="#price" data-bs-toggle="collapse" aria-expanded="true"
                             aria-controls="price">
                            <span>Price</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="price" class="collapse show">
                            <div class="widget-price filter-price">
                                <div class="price-val-range" id="price-value-range" data-min="0"
                                     data-max="100000"></div>
                                <div class="box-title-price">
                                    <span class="title-price">Price :</span>
                                    <div class="caption-price">
                                        <div class="price-val" id="price-min-value" data-currency="₺"></div>
                                        <span>-</span>
                                        <div class="price-val" id="price-max-value" data-currency="₺"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="widget-facet">
                        <div class="facet-title" data-bs-target="#size" data-bs-toggle="collapse" aria-expanded="true"
                             aria-controls="size">
                            <span>Size</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="size" class="collapse show">
                            <ul class="tf-filter-group current-scrollbar">
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="radio" name="size" class="tf-check tf-check-size" value="S" id="S">
                                    <label for="S" class="label"><span>S</span>&nbsp;<span>(7)</span></label>
                                </li>
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="radio" name="size" class="tf-check tf-check-size" value="M" id="M">
                                    <label for="M" class="label"><span>M</span>&nbsp;<span>(8)</span></label>
                                </li>
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="radio" name="size" class="tf-check tf-check-size" value="L" id="L">
                                    <label for="L" class="label"><span>L</span>&nbsp;<span>(8)</span></label>
                                </li>
                                <li class="list-item d-flex gap-12 align-items-center">
                                    <input type="radio" name="size" class="tf-check tf-check-size" value="XL" id="XL">
                                    <label for="XL" class="label"><span>XL</span>&nbsp;<span>(6)</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Filter -->

@endsection
@push('scripts')
    <script type="text/javascript" src="{{asset('front/js/nouislider.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('front/js/shop.js')}}"></script>
    <script>
        $(document).on('click', '.quickview', function () {
            const productId = $(this).data('id');

            $.get(`/quick-view/${productId}`, function (data) {
                console.log(data)
                // Başlık ve fiyat
                $('#quick_view .tf-product-info-title h5 a').text(data.name);
                $('#quick_view .tf-product-info-price .price').text(data.price);

                // Açıklama
                $('#quick_view .tf-product-description').html(data.description);

                // Swiper temizle ve yeni görseller ekle
                let swiperWrapper = $('#quick_view .swiper-wrapper');
                swiperWrapper.html('');
                data.images.forEach(url => {
                    swiperWrapper.append(`
                <div class="swiper-slide">
                    <div class="item">
                        <img src="${url}" alt="${data.name}">
                    </div>
                </div>
            `);
                });
                // Swiper'ı yenile
                if(window.quickViewSwiper){
                    window.quickViewSwiper.update();
                } else {
                    window.quickViewSwiper = new Swiper('.tf-single-slide', {
                        navigation: {
                            nextEl: '.single-slide-next',
                            prevEl: '.single-slide-prev',
                        },
                    });
                }

                // Varyantlar alanı
                let variantsHtml = '';
                data.variants.forEach((variant, index) => {
                    variantsHtml += `
                <div class="variant-picker-item mt-3">
                    <div class="variant-picker-label">
                        ${variant.option}:
                    </div>
                    <div class="variant-picker-values mt-2 d-flex gap-2 flex-wrap">
            `;
                    variant.values.forEach(value => {
                        variantsHtml += `
                    <label class="style-text cursor-pointer p-2 border rounded">
                        <p class="mb-0">${value}</p>
                    </label>
                `;
                    });
                    variantsHtml += `</div></div>`;
                });
                $('#quick_view .tf-product-info-variant-picker').html(variantsHtml);

                // Modalı aç
                $('#quick_view').modal('show');
            });
        });
    </script>

@endpush
