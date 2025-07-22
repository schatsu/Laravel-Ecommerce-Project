@extends('app.layouts.main')
@section('title', 'Hesap Detaylarım')
@section('content')
    <!-- page-title -->
    <x-page-title-component :name="$name = 'Hesap Detaylarım'"/>
    <!-- /page-title -->
    <!-- page-cart -->
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content account-edit">
                        <div class="">
                            <form class="" id="form-password-change" action="#">
                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder=" " type="text" id="property1" name="first name">
                                    <label class="tf-field-label fw-4 text_black-2" for="property1">Ad Soyad</label>
                                </div>
                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder=" " type="email" id="property3" name="email">
                                    <label class="tf-field-label fw-4 text_black-2" for="property3">E-Posta</label>
                                </div>
                                <h6 class="mb_20">Şifre Değişikliği</h6>
                                <div class="tf-field style-1 mb_30">
                                    <input class="tf-field-input tf-input" placeholder=" " type="password" id="property4" name="password">
                                    <label class="tf-field-label fw-4 text_black-2" for="property4">Mevcut şifre</label>
                                </div>
                                <div class="tf-field style-1 mb_30">
                                    <input class="tf-field-input tf-input" placeholder=" " type="password" id="property5" name="password">
                                    <label class="tf-field-label fw-4 text_black-2" for="property5">Yeni şifre</label>
                                </div>
                                <div class="tf-field style-1 mb_30">
                                    <input class="tf-field-input tf-input" placeholder=" " type="password" id="property6" name="password">
                                    <label class="tf-field-label fw-4 text_black-2" for="property6">Yeni şifre tekrarı</label>
                                </div>
                                <div class="mb_20">
                                    <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Bilgilerimi Güncelle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-cart -->
@endsection
