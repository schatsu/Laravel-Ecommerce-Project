@extends('app.layouts.main')
@section('title', 'Ödeme Başarısız')
@section('content')
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="mb_30">
                        <i class="icon-close" style="font-size: 80px; color: #dc3545;"></i>
                    </div>
                    <h3 class="text-danger mb_15">Ödeme Başarısız</h3>
                    <p class="text-muted mb_30">
                        {{ session('error') ?? 'Ödeme işlemi tamamlanamadı. Lütfen tekrar deneyin.' }}
                    </p>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('cart.index') }}" class="tf-btn btn-outline-dark radius-3">
                            Sepete Dön
                        </a>
                        <a href="{{ route('checkout.index') }}" class="tf-btn btn-fill animate-hover-btn radius-3">
                            Tekrar Dene
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
