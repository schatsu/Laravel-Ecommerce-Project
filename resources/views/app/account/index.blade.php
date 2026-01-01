@extends('app.layouts.main')
@section('title', 'Hesabım')
@section('content')
    <!-- page-title -->
    <x-page-title-component :name="$name = 'Hesabım'"/>
    <!-- /page-title -->


    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content account-dashboard">
                        <div class="mb_60">
                            <h5 class="fw-5 mb_20">Merhaba {{auth()?->user()?->full_name}}</h5>
                            <p>
                                Hesap kontrol panelinizden <a class="text_primary" href="{{route('account.orders.index')}}">son siparişlerinizi görüntüleyebilir</a>, <a class="text_primary" href="{{route('account.address')}}">fatura ve teslimat adreslerinizi yönetebilir</a> ve <a class="text_primary" href="{{route('account.account.details')}}">şifrenizi ve hesap bilgilerinizi düzenleyebilirsiniz</a>.
                            </p>
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
                <span class="title">Hesabım</span>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </header>
            <div class="canvas-body sidebar-mobile-append"> </div>
        </div>
    </div>
    <!-- End sidebar account -->
@endsection
