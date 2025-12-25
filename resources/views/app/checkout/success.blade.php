@extends('app.layouts.main')
@section('title', 'Sipariş Başarılı')
@push('css')
    <style>
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }
        .success-icon svg {
            width: 50px;
            height: 50px;
            color: white;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .success-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 8px;
        }
        .success-subtitle {
            color: #666;
            font-size: 1rem;
        }
        .order-info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .order-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .order-info-row:last-child {
            border-bottom: none;
        }
        .order-info-label {
            color: #666;
            font-size: 14px;
        }
        .order-info-value {
            font-weight: 600;
            color: #111;
        }
        .order-number-badge {
            font-family: monospace;
            font-size: 14px;
            background: #000;
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }
        .status-paid {
            background: #10b981;
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .order-items-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #111;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #000;
            display: inline-block;
        }
        .order-item {
            display: flex;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: #f8f8f8;
            border-radius: 8px;
            margin-right: 16px;
        }
        .order-item-details {
            flex-grow: 1;
        }
        .order-item-name {
            font-weight: 600;
            color: #111;
            margin-bottom: 4px;
        }
        .order-item-variant {
            font-size: 13px;
            color: #888;
        }
        .order-item-price {
            text-align: right;
        }
        .order-item-qty {
            font-size: 13px;
            color: #888;
        }
        .order-item-total {
            font-weight: 700;
            font-size: 15px;
            color: #111;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .summary-row.total {
            border-top: 2px solid #000;
            margin-top: 12px;
            padding-top: 16px;
        }
        .summary-label {
            color: #666;
        }
        .summary-value {
            font-weight: 500;
        }
        .summary-total-label {
            font-size: 16px;
            font-weight: 700;
        }
        .summary-total-value {
            font-size: 20px;
            font-weight: 700;
            color: #000;
        }
        .address-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .address-title {
            font-size: 14px;
            font-weight: 700;
            color: #111;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .address-text {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }
        .action-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-primary-custom {
            background: #000;
            color: #fff;
            border: none;
            padding: 14px 32px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            background: #333;
            color: #fff;
        }
        .btn-secondary-custom {
            background: transparent;
            color: #000;
            border: 2px solid #000;
            padding: 12px 28px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-secondary-custom:hover {
            background: #000;
            color: #fff;
        }
        .confetti-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1000;
        }
    </style>
@endpush
@section('content')
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    {{-- Success Header --}}
                    <div class="text-center mb-5">
                        <div class="success-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h1 class="success-title">Siparişiniz Alındı!</h1>
                        <p class="success-subtitle">Teşekkür ederiz. Siparişiniz başarıyla oluşturuldu.</p>
                    </div>

                    {{-- Order Info Card --}}
                    <div class="order-info-card">
                        <div class="order-info-row">
                            <span class="order-info-label">Sipariş Numarası</span>
                            <span class="order-number-badge">{{ $order->order_number }}</span>
                        </div>
                        <div class="order-info-row">
                            <span class="order-info-label">Tarih</span>
                            <span class="order-info-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="order-info-row">
                            <span class="order-info-label">Ödeme Durumu</span>
                            <span class="status-paid">Ödendi</span>
                        </div>
                    </div>

                    {{-- Order Items Card --}}
                    <div class="order-items-card">
                        <h3 class="section-title">Sipariş Detayları</h3>

                        @foreach($order->items as $item)
                            <div class="order-item">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="order-item-image">
                                <div class="order-item-details">
                                    <p class="order-item-name">{{ $item->name }}</p>
                                    @if($item->variation_info)
                                        <span class="order-item-variant">{{ $item->variation_info }}</span>
                                    @endif
                                </div>
                                <div class="order-item-price">
                                    <span class="order-item-qty">{{ $item->quantity }} x {{ number_format($item->unit_price, 2, ',', '.') }} ₺</span>
                                    <p class="order-item-total mb-0">{{ number_format($item->total, 2, ',', '.') }} ₺</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            <div class="summary-row">
                                <span class="summary-label">Ara Toplam</span>
                                <span class="summary-value">{{ number_format($order->subtotal, 2, ',', '.') }} ₺</span>
                            </div>
                            @if($order->discount_amount > 0)
                                <div class="summary-row">
                                    <span class="summary-label">İndirim</span>
                                    <span class="summary-value text-success">-{{ number_format($order->discount_amount, 2, ',', '.') }} ₺</span>
                                </div>
                            @endif
                            <div class="summary-row">
                                <span class="summary-label">Kargo</span>
                                <span class="summary-value">{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', '.') . ' ₺' : 'Ücretsiz' }}</span>
                            </div>
                            <div class="summary-row total">
                                <span class="summary-total-label">Toplam</span>
                                <span class="summary-total-value">{{ number_format($order->total, 2, ',', '.') }} ₺</span>
                            </div>
                        </div>
                    </div>

                    {{-- Delivery Address --}}
                    <div class="address-card">
                        <h4 class="address-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="me-2">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                            Teslimat Adresi
                        </h4>
                        <p class="address-text mb-0">
                            <strong>{{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</strong><br>
                            {{ $order->shipping_address['address'] ?? '' }}<br>
                            {{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}
                        </p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="action-buttons">
                        <a href="{{ route('account.orders') }}" class="btn-secondary-custom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Siparişlerim
                        </a>
                        <a href="{{ route('home') }}" class="btn-primary-custom">
                            Alışverişe Devam Et
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
