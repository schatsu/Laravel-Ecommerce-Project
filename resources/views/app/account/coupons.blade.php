@extends('app.layouts.main')
@section('title', 'Kuponlarım')
@section('content')
    <!-- page-title -->
    <x-page-title-component :name="$name = 'Kuponlarım'"/>
    <!-- /page-title -->

    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content">
                        {{-- Aktif Kupon --}}
                        @if($activeCoupon)
                            <div class="mb_40">
                                <h5 class="fw-5 mb_20">
                                    <i class="icon-gift me-2"></i>Aktif Kuponunuz
                                </h5>
                                <div class="coupon-card active-coupon p-4 rounded-3" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="coupon-code fs-4 fw-bold mb-2">
                                                {{ $activeCoupon->code }}
                                            </div>
                                            <div class="coupon-name mb-1">{{ $activeCoupon->name }}</div>
                                            <div class="coupon-value fs-5">
                                                <strong>{{ $activeCoupon->formatted_value }}</strong> indirim
                                            </div>
                                            @if($activeCoupon->min_order_amount)
                                                <small class="opacity-75">
                                                    Min. sepet: {{ number_format($activeCoupon->min_order_amount, 2, ',', '.') }} ₺
                                                </small>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            @if($activeCoupon->expires_at)
                                                <div class="mb-2">
                                                    <small class="opacity-75">Geçerlilik:</small><br>
                                                    <span>{{ $activeCoupon->expires_at->format('d.m.Y') }}</span>
                                                </div>
                                            @else
                                                <small class="opacity-75">Süresiz</small>
                                            @endif
                                            <span class="badge bg-white text-success mt-2">Sepetinizde Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb_40">
                                <h5 class="fw-5 mb_20">
                                    <i class="icon-gift me-2"></i>Aktif Kuponunuz
                                </h5>
                                <div class="alert alert-light border">
                                    <i class="icon-tag me-2"></i>
                                    Şu anda aktif bir kuponunuz bulunmuyor. Sepetinize kupon kodu girerek indirim kazanabilirsiniz.
                                </div>
                            </div>
                        @endif

                        {{-- Kullanılmış Kuponlar --}}
                        <div class="mb_40">
                            <h5 class="fw-5 mb_20">
                                <i class="icon-history me-2"></i>Kullandığınız Kuponlar
                            </h5>
                            
                            @if($usedCoupons->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kupon Kodu</th>
                                                <th>İndirim</th>
                                                <th>Sipariş No</th>
                                                <th>Tarih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usedCoupons as $usage)
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold text-muted">{{ $usage->coupon?->code ?? '-' }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ $usage->coupon?->name }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="text-success fw-bold">
                                                            -{{ number_format($usage->discount_amount, 2, ',', '.') }} ₺
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($usage->order)
                                                            <a href="{{ route('account.orders.show', $usage->order) }}" class="text-primary">
                                                                {{ $usage->order->order_number }}
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $usage->created_at->format('d.m.Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-light border">
                                    <i class="icon-info-circle me-2"></i>
                                    Henüz bir sipariş için kupon kullanmadınız.
                                </div>
                            @endif
                        </div>

                        {{-- Kupon Kullanma Bilgisi --}}
                        <div class="p-4 bg-light rounded-3">
                            <h6 class="fw-bold mb-3">
                                <i class="icon-help-circle me-2"></i>Kupon Nasıl Kullanılır?
                            </h6>
                            <ol class="mb-0 ps-3">
                                <li class="mb-2">Sepetinize ürün ekleyin</li>
                                <li class="mb-2">Sepet sayfasında "Kupon kodunuz" alanına kupon kodunu girin</li>
                                <li class="mb-2">"Uygula" butonuna tıklayın</li>
                                <li>İndiriminiz otomatik olarak hesaplanacaktır</li>
                            </ol>
                        </div>
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
                <span class="title">SIDEBAR ACCOUNT</span>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body sidebar-mobile-append"> </div>
        </div>
    </div>
    <!-- End sidebar account -->
@endsection
