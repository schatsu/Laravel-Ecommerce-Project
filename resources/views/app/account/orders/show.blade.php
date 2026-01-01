@extends('app.layouts.main')
@section('title', 'Sipariş Detayı - ' . $order->order_number)
@push('css')
<style>
    .order-detail-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }

    .detail-card-header {
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        padding: 16px 20px;
        border-bottom: 1px solid #eee;
    }

    .detail-card-header h6 {
        font-weight: 700;
        font-size: 14px;
        color: #1a1a1a;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-card-body {
        padding: 20px;
    }

    /* Order Header */
    .order-header-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        padding: 24px;
    }

    .order-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .order-main-info h4 {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .order-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .order-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
    }

    .order-meta-item i {
        color: #999;
    }

    .order-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 24px;
        font-size: 13px;
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

    /* Products */
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #fafafa;
        border-radius: 12px;
        transition: background 0.2s ease;
    }

    .product-item:hover {
        background: #f5f5f5;
    }

    .product-image {
        width: 90px;
        height: 90px;
        border-radius: 10px;
        object-fit: contain;
        background: #fff;
        border: 1px solid #eee;
        padding: 6px;
    }

    .product-details {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-weight: 600;
        font-size: 15px;
        color: #1a1a1a;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .product-variant {
        font-size: 13px;
        color: #888;
        margin-bottom: 6px;
    }

    .product-qty-price {
        font-size: 13px;
        color: #666;
    }

    .product-total {
        text-align: right;
    }

    .product-total-amount {
        font-weight: 700;
        font-size: 16px;
        color: #1a1a1a;
    }

    /* Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: 14px;
    }

    .summary-row.total {
        border-top: 2px solid #eee;
        margin-top: 8px;
        padding-top: 16px;
    }

    .summary-label {
        color: #666;
    }

    .summary-value {
        font-weight: 500;
        color: #1a1a1a;
    }

    .summary-row.total .summary-label,
    .summary-row.total .summary-value {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Address */
    .address-content {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .address-name {
        font-weight: 700;
        font-size: 15px;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .address-line {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }

    .address-phone {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #666;
        margin-top: 8px;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }

    .address-phone i {
        color: #999;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: transparent;
        color: #1a1a1a;
        border: 2px solid #1a1a1a;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #1a1a1a;
        color: #fff;
    }

    .btn-back i {
        transition: transform 0.3s ease;
    }

    .btn-back:hover i {
        transform: translateX(-4px);
    }

    @media (max-width: 768px) {
        .order-header-top {
            flex-direction: column;
        }

        .product-item {
            flex-wrap: wrap;
        }

        .product-image {
            width: 70px;
            height: 70px;
        }

        .product-total {
            width: 100%;
            text-align: left;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #ddd;
        }
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
                        <div class="order-detail-container">
                            <!-- Sipariş Başlığı -->
                            <div class="order-header-card">
                                <div class="order-header-top">
                                    <div class="order-main-info">
                                        <h4>Sipariş #{{ $order->order_number }}</h4>
                                        <div class="order-meta">
                                            <span class="order-meta-item">
                                                <i class="icon-calendar"></i>
                                                {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                            </span>
                                            <span class="order-meta-item">
                                                <i class="icon-box"></i>
                                                {{ $order->items->count() }} ürün
                                            </span>
                                        </div>
                                    </div>
                                    <span class="order-status-badge {{ $order->status->value }}">
                                        <i class="{{ $order->status->icon() }}"></i>
                                        {{ $order->status->label() }}
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Ürünler -->
                                <div class="col-lg-8 mb-4">
                                    <div class="detail-card">
                                        <div class="detail-card-header">
                                            <h6><i class="icon-bag me-2"></i>Sipariş Ürünleri</h6>
                                        </div>
                                        <div class="detail-card-body">
                                            <div class="product-list">
                                                @foreach($order->items as $item)
                                                    <div class="product-item">
                                                        <img src="{{ $item->image_url }}"
                                                             alt="{{ $item->name }}"
                                                             class="product-image">
                                                        <div class="product-details">
                                                            <p class="product-name">{{ $item->name }}</p>
                                                            @if($item->variation_info)
                                                                <p class="product-variant">{{ $item->variation_info }}</p>
                                                            @endif
                                                            <p class="product-qty-price">
                                                                {{ $item->quantity }} adet × {{ number_format($item->unit_price, 2, ',', '.') }} ₺
                                                            </p>
                                                        </div>
                                                        <div class="product-total">
                                                            <span class="product-total-amount">{{ number_format($item->total, 2, ',', '.') }} ₺</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('account.orders.index') }}" class="btn-back">
                                            <i class="icon-arrow-left"></i>
                                            Siparişlerime Dön
                                        </a>
                                    </div>
                                </div>

                                <!-- Özet ve Adres -->
                                <div class="col-lg-4">
                                    <!-- Sipariş Özeti -->
                                    <div class="detail-card mb-4">
                                        <div class="detail-card-header">
                                            <h6><i class="icon-document me-2"></i>Sipariş Özeti</h6>
                                        </div>
                                        <div class="detail-card-body">
                                            <div class="summary-row">
                                                <span class="summary-label">Ara Toplam</span>
                                                <span class="summary-value">{{ number_format($order->subtotal, 2, ',', '.') }} ₺</span>
                                            </div>
                                            <div class="summary-row">
                                                <span class="summary-label">Kargo</span>
                                                <span class="summary-value">
                                                    {{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', '.') . ' ₺' : 'Ücretsiz' }}
                                                </span>
                                            </div>
                                            @if($order->discount_amount > 0)
                                                <div class="summary-row">
                                                    <span class="summary-label">İndirim</span>
                                                    <span class="summary-value" style="color: #059669;">-{{ number_format($order->discount_amount, 2, ',', '.') }} ₺</span>
                                                </div>
                                            @endif
                                            <div class="summary-row total">
                                                <span class="summary-label">Toplam</span>
                                                <span class="summary-value">{{ number_format($order->total, 2, ',', '.') }} ₺</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Teslimat Adresi -->
                                    <div class="detail-card">
                                        <div class="detail-card-header">
                                            <h6><i class="icon-place me-2"></i>Teslimat Adresi</h6>
                                        </div>
                                        <div class="detail-card-body">
                                            <div class="address-content">
                                                <p class="address-name">
                                                    {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}
                                                </p>
                                                <p class="address-line">{{ $order->shipping_address['address'] ?? '' }}</p>
                                                <p class="address-line">
                                                    {{ $order->shipping_address['district'] ?? '' }}{{ !empty($order->shipping_address['district']) ? ', ' : '' }}{{ $order->shipping_address['city'] ?? '' }}
                                                </p>
                                                @if(!empty($order->shipping_address['phone']))
                                                    <div class="address-phone">
                                                        <i class="icon-phone"></i>
                                                        {{ $order->shipping_address['phone'] }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
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
