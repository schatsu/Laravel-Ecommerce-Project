@extends('app.layouts.main')
@section('title', 'Sipariş Detayı - ' . $order->order_number)
@push('css')
<style>
    .order-detail-header,
    .order-products-card,
    .order-summary-card,
    .order-address-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
    }
</style>
@endpush
@section('content')
    <x-page-title-component :name="'Sipariş Detayı'"/>
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content account-order-detail">
                        <!-- Sipariş Başlığı -->
                        <div class="order-detail-header mb_30">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-15">
                                <div>
                                    <h5 class="mb_10">Sipariş #{{ $order->order_number }}</h5>
                                    <p class="text-muted mb-0">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                                <div class="d-flex gap-15">
                                    <div class="text-center">
                                        <small class="text-muted d-block mb-1">Ödeme</small>
                                        <span class="badge bg-{{ $order->payment_status->color() }}" style="font-size: 14px;">
                                            {{ $order->payment_status->label() }}
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted d-block mb-1">Sipariş</small>
                                        <span class="badge bg-{{ $order->status->color() }}" style="font-size: 14px;">
                                            {{ $order->status->label() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Ürünler -->
                            <div class="col-lg-8 mb_30">
                                <div class="order-products-card">
                                    <h6 class="mb_20">Sipariş Ürünleri</h6>
                                    @foreach($order->items as $item)
                                        <div class="order-product-item d-flex gap-15 mb_15 pb_15 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <img src="{{ $item->image_url }}"
                                                 alt="{{ $item->name }}"
                                                 style="width: 100px; height: 100px; object-fit: contain; border-radius: 4px;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb_5">{{ $item->name }}</h6>
                                                @if($item->variation_info)
                                                    <p class="text-muted mb_5" style="font-size: 13px;">{{ $item->variation_info }}</p>
                                                @endif
                                                <p class="mb-0">
                                                    <span class="text-muted">{{ $item->quantity }} x {{ number_format($item->unit_price, 2, ',', '.') }} ₺</span>
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-6">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                              <div class="mt_20">
                                  <a href="{{ route('account.orders.index') }}" class="tf-btn btn-outline-dark animate-hover-btn">
                                      <i class="icon-arrow-left me-1"></i> Siparişlerime Dön
                                  </a>
                              </div>
                            </div>
                            <!-- Özet ve Adres -->
                            <div class="col-lg-4">
                                <!-- Sipariş Özeti -->
                                <div class="order-summary-card mb_20">
                                    <h6 class="mb_15">Sipariş Özeti</h6>
                                    <div class="d-flex justify-content-between mb_10">
                                        <span>Ara Toplam</span>
                                        <span>{{ number_format($order->subtotal, 2, ',', '.') }} ₺</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb_10">
                                        <span>Kargo</span>
                                        <span>{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', '.') . ' ₺' : 'Ücretsiz' }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Toplam</strong>
                                        <strong class="text-muted">{{ number_format($order->total, 2, ',', '.') }} ₺</strong>
                                    </div>
                                </div>
                                <!-- Teslimat Adresi -->
                                <div class="order-address-card">
                                    <h6 class="mb_15">Teslimat Adresi</h6>
                                    <p class="mb_5">
                                        <strong>{{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</strong>
                                    </p>
                                    <p class="text-muted mb_5">{{ $order->shipping_address['address'] ?? '' }}</p>
                                    <p class="text-muted mb_5">
                                        {{ $order->shipping_address['district'] ?? '' }}{{ !empty($order->shipping_address['district']) ? ', ' : '' }}{{ $order->shipping_address['city'] ?? '' }}
                                    </p>
                                    @if(!empty($order->shipping_address['phone']))
                                        <p class="text-muted mb-0">
                                            <i class="icon-phone me-1"></i> {{ $order->shipping_address['phone'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
