@extends('app.layouts.main')
@section('title', 'Siparişlerim')
@push('css')
<style>
    .orders-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .order-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .order-card-header {
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        border-bottom: 1px solid #eee;
    }

    .order-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .order-number {
        font-weight: 700;
        font-size: 15px;
        color: #1a1a1a;
        letter-spacing: 0.3px;
    }

    .order-date {
        font-size: 13px;
        color: #888;
    }

    .order-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .order-status-badge.pending {
        background: #fff8e6;
        color: #b8860b;
        border: 1px solid #f0d78c;
    }

    .order-status-badge.processing {
        background: #e6f3ff;
        color: #0066cc;
        border: 1px solid #99c9ff;
    }

    .order-status-badge.shipped {
        background: #e6f7ff;
        color: #0891b2;
        border: 1px solid #67e8f9;
    }

    .order-status-badge.delivered {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #6ee7b7;
    }

    .order-status-badge.cancelled {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    .order-status-badge i {
        font-size: 14px;
    }

    .order-card-body {
        padding: 20px;
    }

    .order-products {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px;
        background: #fafafa;
        border-radius: 12px;
        transition: background 0.2s ease;
    }

    .product-item:hover {
        background: #f5f5f5;
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: contain;
        background: #fff;
        border: 1px solid #eee;
        padding: 4px;
    }

    .product-details {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .product-variant {
        font-size: 12px;
        color: #888;
        margin-bottom: 4px;
    }

    .product-quantity {
        font-size: 12px;
        color: #666;
        background: #eee;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    .product-price {
        font-weight: 700;
        font-size: 15px;
        color: #1a1a1a;
        white-space: nowrap;
    }

    .more-products {
        text-align: center;
        padding: 8px;
        background: #f5f5f5;
        border-radius: 8px;
        font-size: 13px;
        color: #666;
    }

    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #fafafa;
        border-top: 1px solid #eee;
        flex-wrap: wrap;
        gap: 12px;
    }

    .order-total {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .order-total-label {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-total-amount {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .btn-order-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #1a1a1a;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-order-detail:hover {
        background: #333;
        color: #fff;
        transform: translateX(4px);
    }

    .btn-order-detail i {
        transition: transform 0.3s ease;
    }

    .btn-order-detail:hover i {
        transform: translateX(4px);
    }

    .empty-orders {
        text-align: center;
        padding: 60px 20px;
        background: #fafafa;
        border-radius: 16px;
    }

    .empty-orders-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .empty-orders-icon i {
        font-size: 40px;
        color: #999;
    }

    .empty-orders h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .empty-orders p {
        color: #888;
        margin-bottom: 24px;
    }

    @media (max-width: 576px) {
        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-item {
            flex-wrap: wrap;
        }

        .product-image {
            width: 60px;
            height: 60px;
        }

        .order-card-footer {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .btn-order-detail {
            justify-content: center;
        }
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
                            <div class="orders-container">
                                @foreach($orders as $order)
                                    <div class="order-card">
                                        <div class="order-card-header">
                                            <div class="order-info">
                                                <span class="order-number">#{{ $order->order_number }}</span>
                                                <span class="order-date">
                                                    <i class="icon-calendar"></i>
                                                    {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                                </span>
                                            </div>
                                            <span class="order-status-badge {{ $order->status->value }}">
                                                <i class="{{ $order->status->icon() }}"></i>
                                                {{ $order->status->label() }}
                                            </span>
                                        </div>

                                        <div class="order-card-body">
                                            <div class="order-products">
                                                @foreach($order->items->take(2) as $item)
                                                    <div class="product-item">
                                                        <img src="{{ $item->image_url }}"
                                                             alt="{{ $item->name }}"
                                                             class="product-image">
                                                        <div class="product-details">
                                                            <p class="product-name">{{ Str::limit($item->name, 50) }}</p>
                                                            @if($item->variation_info)
                                                                <p class="product-variant">{{ Str::limit($item->variation_info, 40) }}</p>
                                                            @endif
                                                            <span class="product-quantity">{{ $item->quantity }} adet</span>
                                                        </div>
                                                        <span class="product-price">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                                    </div>
                                                @endforeach
                                                @if($order->items->count() > 2)
                                                    <div class="more-products">
                                                        <i class="icon-plus"></i> {{ $order->items->count() - 2 }} ürün daha
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="order-card-footer">
                                            <div class="order-total">
                                                <span class="order-total-label">Sipariş Toplamı</span>
                                                <span class="order-total-amount">{{ number_format($order->total, 2, ',', '.') }} ₺</span>
                                            </div>
                                            <a href="{{ route('account.orders.show', $order->hashid()) }}" class="btn-order-detail">
                                                Sipariş Detayı
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tf-pagination-wrap d-flex justify-content-center align-items-center mt_30">
                                {{ $orders->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <div class="empty-orders">
                                <div class="empty-orders-icon">
                                    <i class="icon-box"></i>
                                </div>
                                <h5>Henüz siparişiniz bulunmuyor</h5>
                                <p>Alışverişe başlayarak ilk siparişinizi oluşturun.</p>
                                <a href="{{ route('home') }}" class="tf-btn btn-fill animate-hover-btn">
                                    <i class="icon-bag me-2"></i>
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
