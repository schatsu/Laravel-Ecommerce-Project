@extends('app.layouts.main')
@section('title', 'Favorilerim')
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
    <x-page-title-component :name="$name = 'Favorilerim'"/>
    <!-- /page-title -->
            
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content">
                        @if($favorites->count() > 0)
                            <div class="tf-grid-layout wrapper-shop tf-col-4">
                                @foreach($favorites as $product)
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
                                                   data-slug="{{ $product->slug }}"
                                                   class="box-icon bg_white wishlist-toggle btn-icon-action favorited">
                                                    <span class="icon icon-heart"></span><span
                                                        class="tooltip">Favorilerden Çıkar</span><span
                                                        class="icon icon-delete"></span>
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
                            </div>
                            <div class="mt-4">
                                {{ $favorites->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="icon icon-heart" style="font-size: 64px; color: #ddd;"></i>
                                <h5 class="mt-4 mb-3">Favori listeniz boş</h5>
                                <p class="text-muted mb-4">Beğendiğiniz ürünleri favorilere ekleyerek daha sonra kolayca bulabilirsiniz.</p>
                                <a href="{{ route('category.index') }}" class="tf-btn btn-fill animate-hover-btn">
                                    <span>Alışverişe Başla</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="btn-sidebar-account">
        <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount" aria-controls="offcanvas"><i class="icon icon-sidebar-2"></i></button>
    </div>
    <!-- sidebar account-->
    <div class="offcanvas offcanvas-start canvas-filter canvas-sidebar canvas-sidebar-account" id="mbAccount">
        <div class="canvas-wrapper">
            <header class="canvas-header">
                <span class="title">Profil</span>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body sidebar-mobile-append"> </div>
        </div>
    </div>
    <!-- End sidebar account -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.wishlist-toggle', function (e) {
                e.preventDefault();

                let $btn = $(this);
                let slug = $btn.data('slug');
                let $card = $btn.closest('.card-product');

                $btn.addClass('loading');

                axios.post('{{ route("account.favorite.toggle", ":slug") }}'.replace(':slug', slug))
                    .then(function (response) {
                        if (response.data.success) {
                            $('.favorites-count').text(response.data.data.favorites_count);

                            if (!response.data.data.is_favorited) {
                                $card.fadeOut(300, function() {
                                    $(this).remove();
                                    if ($('.card-product').length === 0) {
                                        location.reload();
                                    }
                                });
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: response.data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(function (error) {
                        console.error('Favori hatası:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: error.response?.data?.message || 'Bir hata oluştu.'
                        });
                    })
                    .finally(function () {
                        $btn.removeClass('loading');
                    });
            });
        });
    </script>
@endpush

