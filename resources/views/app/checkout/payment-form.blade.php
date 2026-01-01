@extends('app.layouts.main')
@section('title', 'Ödeme')
@push('css')
<style>
    .credit-card-preview {
        perspective: 1000px;
        margin-bottom: 30px;
    }

    .credit-card {
        width: 100%;
        max-width: 380px;
        height: 220px;
        margin: 0 auto;
        border-radius: 20px;
        position: relative;
        transition: transform 0.6s ease-in-out;
        transform-style: preserve-3d;
    }

    .credit-card.flipped {
        transform: rotateY(180deg);
    }

    .card-front, .card-back {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 20px;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        overflow: hidden;
    }

    .card-front {
        background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 50%, #0d0d0d 100%);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        padding: 24px;
        display: flex;
        flex-direction: column;
    }

    .card-front::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        opacity: 0.05;
        pointer-events: none;
    }

    .card-back {
        background: linear-gradient(135deg, #3d3d3d 0%, #2a2a2a 50%, #1a1a1a 100%);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        transform: rotateY(180deg);
    }

    .card-chip {
        width: 50px;
        height: 40px;
        background: linear-gradient(135deg, #d4af37 0%, #c9a227 100%);
        border-radius: 8px;
        position: relative;
        overflow: hidden;
    }

    .card-chip::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30px;
        height: 25px;
        background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.3) 100%);
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 4px;
    }

    .card-chip::after {
        content: '';
        position: absolute;
        top: 12px;
        left: 10px;
        width: 30px;
        height: 2px;
        background: rgba(0,0,0,0.1);
        box-shadow: 0 5px 0 rgba(0,0,0,0.1), 0 10px 0 rgba(0,0,0,0.1), 0 15px 0 rgba(0,0,0,0.1);
    }

    .card-contactless {
        position: absolute;
        top: 24px;
        left: 80px;
        width: 36px;
        height: 36px;
        transform: rotate(90deg);
    }

    .card-contactless svg {
        width: 100%;
        height: 100%;
        fill: none;
        stroke: rgba(255,255,255,0.6);
        stroke-width: 2;
    }

    .card-logo {
        position: absolute;
        top: 20px;
        right: 24px;
        height: 45px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card-logo.visible {
        opacity: 1;
    }

    .card-logo img {
        height: 100%;
    }

    .card-number-display {
        margin-top: auto;
        font-family: 'Courier New', monospace;
        font-size: 22px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 3px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        gap: 16px;
    }

    .card-number-display span {
        display: inline-block;
        min-width: 65px;
    }

    .card-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
    }

    .card-holder-section {
        flex: 1;
    }

    .card-label {
        font-size: 10px;
        color: rgba(255,255,255,0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .card-holder-display {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-expires-section {
        text-align: right;
    }

    .card-expires-display {
        font-family: 'Courier New', monospace;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 2px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    .card-magnetic-stripe {
        width: 100%;
        height: 50px;
        background: #000;
        margin-top: 20px;
    }

    .card-cvv-section {
        display: flex;
        align-items: center;
        padding: 25px 24px;
        gap: 12px;
    }

    .card-signature-area {
        flex: 1;
        height: 45px;
        background: repeating-linear-gradient(
            90deg,
            #f5f5f5,
            #f5f5f5 2px,
            #e8e8e8 2px,
            #e8e8e8 4px
        );
        border-radius: 6px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 12px;
    }

    .card-signature-text {
        font-family: 'Brush Script MT', cursive;
        font-size: 16px;
        color: #333;
        opacity: 0.6;
    }

    .card-cvv-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .card-cvv-label {
        font-size: 9px;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-cvv-display {
        font-family: 'Courier New', monospace;
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        background: #fff;
        padding: 10px 18px;
        border-radius: 6px;
        min-width: 70px;
        text-align: center;
        letter-spacing: 3px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .card-back-info {
        padding: 15px 24px;
        font-size: 8px;
        color: rgba(255,255,255,0.4);
        text-align: center;
        line-height: 1.4;
    }

    .payment-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
    }

    .payment-card-header {
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        padding: 16px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .step-number {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .payment-card-header h5 {
        font-weight: 700;
        font-size: 16px;
        color: #1a1a1a;
        margin: 0;
    }

    .payment-card-body {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .form-control-custom {
        width: 100%;
        padding: 14px 16px;
        font-size: 15px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        transition: all 0.2s ease;
        background: #fff;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #1a1a1a;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
    }

    .form-control-custom::placeholder {
        color: #aaa;
    }

    .installment-section {
        background: linear-gradient(135deg, #fafafa 0%, #fff 100%);
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e8e8e8;
        margin-bottom: 20px;
    }

    .installment-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .installment-section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(180deg, #1a1a1a 0%, #333 100%);
        border-radius: 2px;
    }

    .installment-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    @media (max-width: 576px) {
        .installment-grid {
            grid-template-columns: 1fr;
        }

        .credit-card {
            height: 200px;
        }

        .card-number-display {
            font-size: 18px;
            gap: 10px;
        }
    }

    .installment-card {
        position: relative;
        background: #fff;
        border: 2px solid #e8e8e8;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        overflow: hidden;
    }

    .installment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: transparent;
        transition: background 0.2s ease;
    }

    .installment-card:hover {
        border-color: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .installment-card.selected {
        border-color: #1a1a1a;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .installment-card.selected::before {
        background: linear-gradient(90deg, #1a1a1a 0%, #333 100%);
    }

    .installment-card input {
        display: none;
    }

    .installment-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .installment-label {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-single {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 8px;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #fff;
        border-radius: 4px;
    }

    .installment-check {
        width: 22px;
        height: 22px;
        border: 2px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .installment-card.selected .installment-check {
        border-color: #1a1a1a;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
    }

    .installment-check svg {
        width: 12px;
        height: 12px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .installment-card.selected .installment-check svg {
        opacity: 1;
    }

    .installment-card-body {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .installment-monthly {
        font-size: 12px;
        color: #888;
    }

    .installment-monthly strong {
        color: #1a1a1a;
    }

    .installment-total {
        font-size: 17px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .installment-card.single-payment .installment-total {
        color: #059669;
    }

    .installment-info {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px dashed #ddd;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #888;
    }

    .installment-info svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        color: #888;
    }

    .secure-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        background: linear-gradient(135deg, #e8f4fd 0%, #f0f9ff 100%);
        border-radius: 12px;
        border: 1px solid #b8e3ff;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .secure-checkbox input {
        margin-top: 2px;
        accent-color: #1a1a1a;
    }

    .secure-checkbox-content {
        flex: 1;
    }

    .secure-checkbox-title {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
        margin-bottom: 2px;
    }

    .secure-checkbox-desc {
        font-size: 12px;
        color: #666;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 16px;
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .summary-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .summary-header h6 {
        font-weight: 700;
        font-size: 15px;
        color: #fff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .summary-header svg {
        width: 20px;
        height: 20px;
    }

    .summary-body {
        padding: 20px;
    }

    .order-items-container {
        max-height: 180px;
        overflow-y: auto;
        padding-right: 8px;
        margin-right: -8px;
    }

    .order-items-container::-webkit-scrollbar {
        width: 4px;
    }

    .order-items-container::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 4px;
    }

    .order-items-container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #fafafa;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: background 0.2s ease;
    }

    .order-item:hover {
        background: #f5f5f5;
    }

    .order-item:last-child {
        margin-bottom: 0;
    }

    .order-item-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #eee;
        flex-shrink: 0;
    }

    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .order-item-details {
        flex: 1;
        min-width: 0;
    }

    .order-item-name {
        font-size: 13px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-item-quantity {
        font-size: 12px;
        color: #888;
    }

    .order-item-price {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
        white-space: nowrap;
    }

    .price-breakdown {
        border-top: 1px solid #eee;
        padding-top: 16px;
        margin-top: 16px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .price-row .label {
        font-size: 13px;
        color: #666;
    }

    .price-row .value {
        font-size: 13px;
        font-weight: 500;
        color: #1a1a1a;
    }

    .price-row.discount .value {
        color: #059669;
    }

    .price-row.shipping .value.free {
        color: #059669;
        font-weight: 600;
    }

    .price-row.total {
        border-top: 2px solid #eee;
        margin-top: 10px;
        padding-top: 14px;
    }

    .price-row.total .label,
    .price-row.total .value {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .delivery-section {
        margin-top: 16px;
        padding: 14px;
        background: #fafafa;
        border-radius: 10px;
        border: 1px solid #eee;
    }

    .delivery-section-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .delivery-section-header svg {
        width: 16px;
        height: 16px;
        color: #888;
    }

    .delivery-section-header span {
        font-size: 11px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .delivery-address {
        font-size: 13px;
        color: #555;
        line-height: 1.6;
    }

    .delivery-address strong {
        display: block;
        color: #1a1a1a;
        margin-bottom: 2px;
    }

    .btn-checkout {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    .btn-checkout:disabled {
        background: #999;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .secure-badge {
        text-align: center;
        margin-top: 14px;
        font-size: 12px;
        color: #888;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .secure-badge i {
        color: #059669;
    }

    .alert-custom {
        padding: 14px 16px;
        background: #fef2f2;
        border: 1px solid #fca5a5;
        border-radius: 10px;
        color: #dc2626;
        font-size: 13px;
        margin-bottom: 16px;
    }
</style>
@endpush
@section('content')
    <x-page-title-component :name="'Ödeme'"/>

    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="payment-card">
                        <div class="payment-card-header">
                            <span class="step-number">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </span>
                            <h5>Kart Bilgileri</h5>
                        </div>
                        <div class="payment-card-body">
                            <!-- Interactive Credit Card Preview -->
                            <div class="credit-card-preview">
                                <div class="credit-card" id="credit-card">
                                    <!-- Card Front -->
                                    <div class="card-front">
                                        <div class="card-chip"></div>
                                        <div class="card-contactless">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" fill="none" stroke="currentColor" stroke-width="0"/>
                                                <path d="M8.5 8.5C10.5 6.5 13.5 6.5 15.5 8.5" stroke-linecap="round"/>
                                                <path d="M6.5 6.5C9.5 3.5 14.5 3.5 17.5 6.5" stroke-linecap="round"/>
                                                <path d="M10.5 10.5C11.5 9.5 12.5 9.5 13.5 10.5" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="1.5" fill="rgba(255,255,255,0.6)"/>
                                            </svg>
                                        </div>
                                        <div class="card-logo" id="card-logo">
                                            <img src="" alt="Card Logo" id="card-logo-img">
                                        </div>
                                        <div class="card-number-display" id="card-number-display">
                                            <span>••••</span>
                                            <span>••••</span>
                                            <span>••••</span>
                                            <span>••••</span>
                                        </div>
                                        <div class="card-info-row">
                                            <div class="card-holder-section">
                                                <div class="card-label">Kart Sahibi</div>
                                                <div class="card-holder-display" id="card-holder-display">AD SOYAD</div>
                                            </div>
                                            <div class="card-expires-section">
                                                <div class="card-label">Son Kullanma</div>
                                                <div class="card-expires-display" id="card-expires-display">••/••</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Back -->
                                    <div class="card-back">
                                        <div class="card-magnetic-stripe"></div>
                                        <div class="card-cvv-section">
                                            <div class="card-signature-area">
                                                <span class="card-signature-text">İmza</span>
                                            </div>
                                            <div class="card-cvv-box">
                                                <span class="card-cvv-label">CVV</span>
                                                <div class="card-cvv-display" id="card-cvv-display">•••</div>
                                            </div>
                                        </div>
                                        <div class="card-back-info">
                                            256-bit SSL ile şifrelenmiş güvenli ödeme
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('checkout.pay') }}" method="POST" id="payment-form">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <div class="form-group">
                                    <label>Kart Numarası</label>
                                    <input type="text"
                                           class="form-control-custom"
                                           name="card_number"
                                           id="card-number"
                                           placeholder="0000 0000 0000 0000"
                                           maxlength="19"
                                           autocomplete="cc-number"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Kart Üzerindeki İsim</label>
                                    <input type="text"
                                           class="form-control-custom"
                                           name="holder_name"
                                           id="holder-name"
                                           placeholder="AD SOYAD"
                                           autocomplete="cc-name"
                                           style="text-transform: uppercase;"
                                           required>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Son Kullanma Tarihi</label>
                                            <input type="text"
                                                   class="form-control-custom"
                                                   name="expire_date"
                                                   id="expire-date"
                                                   placeholder="AA/YY"
                                                   maxlength="5"
                                                   autocomplete="cc-exp"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>CVV</label>
                                            <input type="text"
                                                   class="form-control-custom"
                                                   name="cvc"
                                                   id="cvc"
                                                   placeholder="•••"
                                                   maxlength="4"
                                                   autocomplete="cc-csc"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="installment-section" id="installment-section" style="display: none;">
                                    <div class="installment-section-title">Taksit Seçenekleri</div>
                                    <div class="installment-grid" id="installment-options"></div>
                                    <div class="installment-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                        </svg>
                                        <span>Taksit seçenekleri bankanıza göre değişiklik gösterebilir</span>
                                    </div>
                                </div>

                                <label class="secure-checkbox">
                                    <input type="checkbox" name="use_3d_secure" id="use-3d-secure" value="1" checked>
                                    <div class="secure-checkbox-content">
                                        <div class="secure-checkbox-title">3D Secure ile öde</div>
                                        <div class="secure-checkbox-desc">Ekstra güvenlik için önerilir</div>
                                    </div>
                                </label>

                                <div class="alert-custom" id="payment-error" style="display: none;"></div>

                                <button type="submit" class="btn-checkout" id="pay-button">
                                    <i class="icon-lock"></i>
                                    <span id="pay-button-text">{{ number_format($order->total, 2, ',', '.') }} ₺ Öde</span>
                                </button>

                                <div class="secure-badge">
                                    <i class="icon-check"></i>
                                    256-bit SSL ile şifrelenmiş güvenli ödeme
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="summary-card">
                        <div class="summary-header">
                            <h6>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                Sipariş Özeti
                            </h6>
                        </div>
                        <div class="summary-body">
                            <div class="order-items-container">
                                @foreach($order->items as $item)
                                    <div class="order-item">
                                        <div class="order-item-image">
                                            <img src="{{ $item->product?->getFirstMediaUrl('images') ?: asset('images/placeholder.png') }}" alt="{{ $item->name }}">
                                        </div>
                                        <div class="order-item-details">
                                            <div class="order-item-name">{{ $item->name }}</div>
                                            <div class="order-item-quantity">{{ $item->quantity }} adet</div>
                                        </div>
                                        <div class="order-item-price">{{ number_format($item->total, 2, ',', '.') }} ₺</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="price-breakdown">
                                <div class="price-row">
                                    <span class="label">Ara Toplam</span>
                                    <span class="value">{{ number_format($order->subtotal, 2, ',', '.') }} ₺</span>
                                </div>

                                @if($order->discount_amount > 0)
                                    <div class="price-row discount">
                                        <span class="label">İndirim</span>
                                        <span class="value">-{{ number_format($order->discount_amount, 2, ',', '.') }} ₺</span>
                                    </div>
                                @endif

                                <div class="price-row shipping">
                                    <span class="label">Kargo</span>
                                    <span class="value {{ $order->shipping_cost == 0 ? 'free' : '' }}">
                                        {{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 2, ',', '.') . ' ₺' : 'Ücretsiz' }}
                                    </span>
                                </div>

                                <div class="price-row total">
                                    <span class="label">Toplam</span>
                                    <span class="value" id="display-total">{{ number_format($order->total, 2, ',', '.') }} ₺</span>
                                </div>
                            </div>

                            <div class="delivery-section">
                                <div class="delivery-section-header">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span>Teslimat Adresi</span>
                                </div>
                                <div class="delivery-address">
                                    <strong>{{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</strong>
                                    {{ $order->shipping_address['address'] ?? '' }}<br>
                                    {{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    const $cardNumber = $('#card-number');
    const $expireDate = $('#expire-date');
    const $cvc = $('#cvc');
    const $holderName = $('#holder-name');
    const $creditCard = $('#credit-card');
    const $cardLogo = $('#card-logo');
    const $cardLogoImg = $('#card-logo-img');
    const $installmentSection = $('#installment-section');
    const $installmentOptions = $('#installment-options');
    const $payButton = $('#pay-button');
    const $payButtonText = $('#pay-button-text');
    const $paymentError = $('#payment-error');

    const orderTotal = {{ $order->total }};

    const cardLogos = {
        visa: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 60"><rect fill="white" width="100" height="60" rx="5"/><text x="50" y="38" fill="%231A1F71" font-size="18" font-weight="bold" text-anchor="middle" font-family="Arial">VISA</text></svg>',
        mastercard: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 60"><circle cx="38" cy="30" r="20" fill="%23EB001B"/><circle cx="62" cy="30" r="20" fill="%23F79E1B"/><path d="M50 15 A20 20 0 0 1 50 45 A20 20 0 0 1 50 15" fill="%23FF5F00"/></svg>',
        troy: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 60"><rect fill="%230055A4" width="100" height="60" rx="5"/><text x="50" y="38" fill="white" font-size="16" font-weight="bold" text-anchor="middle" font-family="Arial">TROY</text></svg>'
    };

    $cardNumber.on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        value = value.substring(0, 16);

        let formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        $(this).val(formatted);

        const parts = value.match(/.{1,4}/g) || ['', '', '', ''];
        const displayParts = [];
        for (let i = 0; i < 4; i++) {
            if (i === 0 || i === 3) {
                displayParts.push(parts[i] || '••••');
            } else {
                displayParts.push(parts[i] ? '••••' : '••••');
            }
        }
        $('#card-number-display').html(
            `<span>${parts[0] || '••••'}</span>` +
            `<span>${parts[1] ? '••••' : '••••'}</span>` +
            `<span>${parts[2] ? '••••' : '••••'}</span>` +
            `<span>${parts[3] || '••••'}</span>`
        );

        detectCardType(value);

        if (value.length >= 6) {
            getInstallmentOptions(value.substring(0, 6));
        } else {
            $installmentSection.hide();
        }
    });

    $holderName.on('input', function() {
        const value = $(this).val().toUpperCase();
        $(this).val(value);
        $('#card-holder-display').text(value || 'AD SOYAD');
    });

    $expireDate.on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        $(this).val(value);
        $('#card-expires-display').text(value || '••/••');
    });

    $cvc.on('input focus', function() {
        const value = $(this).val().replace(/\D/g, '');
        $(this).val(value);
        $('#card-cvv-display').text(value || '•••');
    });

    $cvc.on('focus', function() {
        $creditCard.addClass('flipped');
    });

    $cvc.on('blur', function() {
        $creditCard.removeClass('flipped');
    });

    function detectCardType(number) {
        $cardLogo.removeClass('visible');

        if (/^4/.test(number)) {
            $cardLogoImg.attr('src', cardLogos.visa);
            $cardLogo.addClass('visible');
        } else if (/^5[1-5]/.test(number) || /^2[2-7]/.test(number)) {
            $cardLogoImg.attr('src', cardLogos.mastercard);
            $cardLogo.addClass('visible');
        } else if (/^9792/.test(number)) {
            $cardLogoImg.attr('src', cardLogos.troy);
            $cardLogo.addClass('visible');
        }
    }

    function luhnCheck(num) {
        let arr = (num + '').split('').reverse().map(x => parseInt(x));
        let sum = arr.reduce((acc, val, i) => {
            if (i % 2 !== 0) {
                val = val * 2;
                if (val > 9) val = val - 9;
            }
            return acc + val;
        }, 0);
        return sum % 10 === 0;
    }

    function getInstallmentOptions(bin) {
        axios.get(`{{ route('checkout.installments', ['bin' => '__BIN__', 'price' => '__PRICE__']) }}`.replace('__BIN__', bin).replace('__PRICE__', orderTotal))
            .then(function(res) {
                const response = res.data;
                if (response.success && response.installments.length > 0) {
                    let html = '';
                    response.installments.forEach(function(inst, index) {
                        const checked = index === 0 ? 'checked' : '';
                        const selected = index === 0 ? 'selected' : '';
                        const isSingle = inst.installment === 1;
                        const singleClass = isSingle ? 'single-payment' : '';
                        const badge = isSingle ? '<span class="badge-single">Önerilen</span>' : '';
                        const label = isSingle ? 'Tek Çekim' : inst.installment + ' Taksit';
                        const monthlyPayment = !isSingle ? `<span class="installment-monthly">Aylık <strong>${inst.installment_price} ₺</strong></span>` : '<span class="installment-monthly">Komisyonsuz</span>';

                        html += `
                        <label class="installment-card ${selected} ${singleClass}">
                            <input type="radio" name="installment" value="${inst.installment}" ${checked}>
                            <div class="installment-card-header">
                                <span class="installment-label">
                                    ${label}
                                    ${badge}
                                </span>
                                <span class="installment-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </span>
                            </div>
                            <div class="installment-card-body">
                                ${monthlyPayment}
                                <span class="installment-total">${inst.total_price} ₺</span>
                            </div>
                        </label>
                    `;
                    });
                    $installmentOptions.html(html);
                    $installmentSection.show();

                    $('.installment-card').click(function() {
                        $('.installment-card').removeClass('selected');
                        $(this).addClass('selected');
                        $(this).find('input').prop('checked', true);

                        const total = $(this).find('.installment-total').text();
                        $('#display-total').text(total);
                        $payButtonText.text(total + ' Öde');
                    });
                }
            });
    }

    $('#payment-form').on('submit', function(e) {
        $paymentError.hide();

        const cardNum = $cardNumber.val().replace(/\s/g, '');
        if (cardNum.length < 15 || !luhnCheck(cardNum)) {
            e.preventDefault();
            $paymentError.text('Geçersiz kart numarası').show();
            return;
        }

        const expire = $expireDate.val();
        if (!/^\d{2}\/\d{2}$/.test(expire)) {
            e.preventDefault();
            $paymentError.text('Geçersiz son kullanma tarihi').show();
            return;
        }

        const cvc = $cvc.val();
        if (cvc.length < 3) {
            e.preventDefault();
            $paymentError.text('Geçersiz CVV').show();
            return;
        }

        $payButton.prop('disabled', true);
        $payButtonText.text('İşleniyor...');
    });
});
</script>
@endpush
