@extends('app.layouts.main')
@section('title', 'Ödeme')
@section('content')
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb_30">
                        <h4>Güvenli Ödeme</h4>
                        <p class="text-muted">Sipariş No: {{ $order->order_number }}</p>
                    </div>
                    
                    <!-- iyzico Checkout Form -->
                    <div id="iyzipay-checkout-form" class="popup"></div>
                    {!! $checkoutFormContent !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
<style>
    #iyzipay-checkout-form {
        min-height: 400px;
    }
</style>
@endpush
