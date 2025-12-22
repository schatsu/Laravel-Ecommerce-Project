@extends('app.layouts.main')
@section('title', 'Sipariş Başarılı')
@section('content')
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb_30">
                        <div class="mb_20">
                            <i class="icon-check" style="font-size: 80px; color: #28a745;"></i>
                        </div>
                        <h3 class="text-success">Siparişiniz Alındı!</h3>
                        <p class="text-muted">Teşekkür ederiz, siparişiniz başarıyla oluşturuldu.</p>
                    </div>

                    <div class="tf-page-cart-footer">
                        <div class="tf-cart-footer-inner">
                            <div class="d-flex justify-content-between mb_15">
                                <span>Sipariş No</span>
                                <strong>{{ $order->order_number }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb_15">
                                <span>Tarih</span>
                                <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb_15">
                                <span>Ödeme Durumu</span>
                                <span class="badge bg-success">Ödendi</span>
                            </div>
                            
                            <hr>
                            
                            <h6 class="mb_15">Sipariş Detayları</h6>
                            
                            @foreach($order->items as $item)
                                <div class="d-flex align-items-center mb_15">
                                    <img src="{{ $item->product->getFirstMediaUrl('images', 'small') ?: asset('images/placeholder.png') }}" 
                                         alt="{{ $item->name }}" 
                                         class="me-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <p class="mb-0">{{ $item->name }}</p>
                                        @if($item->variation_info)
                                            <small class="text-muted">{{ $item->variation_info }}</small>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <small>{{ $item->quantity }} x {{ number_format($item->unit_price, 2, ',', '.') }} ₺</small>
                                        <br>
                                        <strong>{{ number_format($item->total, 2, ',', '.') }} ₺</strong>
                                    </div>
                                </div>
                            @endforeach
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb_10">
                                <span>Ara Toplam</span>
                                <span>{{ number_format($order->subtotal, 2, ',', '.') }} ₺</span>
                            </div>
                            <div class="d-flex justify-content-between mb_10">
                                <span>Kargo</span>
                                <span>{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', '.') . ' ₺' : 'Ücretsiz' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Toplam</strong>
                                <strong class="text-primary">{{ number_format($order->total, 2, ',', '.') }} ₺</strong>
                            </div>
                            
                            <hr>
                            
                            <h6 class="mb_10">Teslimat Adresi</h6>
                            <p class="text-muted mb-0">
                                {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
                                {{ $order->shipping_address['address'] ?? '' }}<br>
                                {{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}
                            </p>
                        </div>
                    </div>

                    <div class="text-center mt_30">
                        <a href="{{ route('home') }}" class="tf-btn btn-fill animate-hover-btn radius-3">
                            Alışverişe Devam Et
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
