@extends('app.layouts.main')
@section('title', 'Siparişlerim')
@push('css')
<style>
    .order-item {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
    }
    .order-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        border-color: #ddd;
    }
</style>
@endpush
@section('content')
    <x-page-title-component :name="'Siparişlerim'"/>
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content account-orders">
                        @if($orders->count() > 0)
                            <div class="orders-list">
                                @foreach($orders as $order)
                                    <div class="order-item mb_20">
                                        <div class="order-header d-flex justify-content-between align-items-center flex-wrap gap-15 mb_15">
                                            <div>
                                                <span class="fw-6">Sipariş No:</span> {{ $order->order_number }}
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</small>
                                            </div>
                                            <div class="d-flex align-items-center gap-15">
                                                <div class="text-center">
                                                    <small class="text-muted d-block mb-1">Ödeme</small>
                                                    <span class="badge bg-{{ $order->payment_status->color() }}">
                                                        {{ $order->payment_status->label() }}
                                                    </span>
                                                </div>
                                                <div class="text-center">
                                                    <small class="text-muted d-block mb-1">Sipariş</small>
                                                    <span class="badge bg-{{ $order->status->color() }}">
                                                        {{ $order->status->label() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-products mb_15">
                                            @foreach($order->items->take(3) as $item)
                                                <div class="d-flex align-items-center gap-10 mb_10">
                                                    <img src="{{ $item->image_url }}"
                                                         alt="{{ $item->name }}"
                                                         style="width: 100px; height: 100px; object-fit: contain; border-radius: 4px;">
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0">{{ Str::limit($item->name, 40) }}</p>
                                                        @if($item->variation_info)
                                                            <small class="text-muted d-block">{{ Str::limit($item->variation_info, 30) }}</small>
                                                        @endif
                                                        <small class="text-muted">{{ $item->quantity }} adet</small>
                                                    </div>
                                                    <span class="fw-5">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 3)
                                                <small class="text-muted">+{{ $order->items->count() - 3 }} ürün daha</small>
                                            @endif
                                        </div>

                                        <div class="order-footer d-flex justify-content-between align-items-center pt_15 border-top">
                                            <div>
                                                <span class="fw-6">Toplam:</span>
                                                <span class="text-muted fw-6">{{ number_format($order->total, 2, ',', '.') }} ₺</span>
                                            </div>
                                            <a href="{{ route('account.orders.show', $order->hashid()) }}" class="tf-btn btn-sm btn-fill animate-hover-btn mt-2">
                                                Detay
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tf-pagination-wrap d-flex justify-content-center align-items-center">
                                {{ $orders->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="icon-box" style="font-size: 60px; color: #ddd;"></i>
                                <h5 class="mt_20 mb_10">Henüz siparişiniz yok</h5>
                                <p class="text-muted mb_20">Alışverişe başlayarak ilk siparişinizi oluşturun.</p>
                                <a href="{{ route('home') }}" class="tf-btn btn-fill animate-hover-btn">
                                    Alışverişe Başla
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
