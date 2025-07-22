@extends('app.layouts.main')
@section('title', 'Giriş Yap')
@section('content')
    <!-- page-title -->
    <div class="tf-page-title style-2">
        <div class="container-full">
            <div class="heading text-center">Giriş Yap</div>
        </div>
    </div>
    <!-- /page-title -->

    <section class="flat-spacing-10">
        <div class="container">
            <div class="tf-grid-layout lg-col-2 tf-login-wrap">
                <div class="tf-login-form">
                    <div id="recover">
                        <h5 class="mb_24">Şifrenizi sıfırlayın</h5>
                        <p class="mb_30">Şifrenizi sıfırlamanız için size bir e-posta göndereceğiz</p>
                        <div>
                            <form id="login-form" action="{{route('password.email')}}" method="post" accept-charset="utf-8">
                                @csrf
                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder="" type="email" id="property3" name="email">
                                    <label class="tf-field-label fw-4 text_black-2" for="property3">E-Posta *</label>
                                </div>
                                <div class="mb_20">
                                    <a href="#login" class="tf-btn btn-line">İptal</a>
                                </div>
                                <div class="">
                                    <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Şifreyi sıfırla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="login">
                        <h5 class="mb_36">Giriş Yap</h5>
                        <div>
                            <form id="login-form" action="{{route('login')}}" accept-charset="utf-8" method="post">
                                @csrf
                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder="" type="email" id="property3" name="email">
                                    <label class="tf-field-label fw-4 text_black-2" for="property3">E-Posta *</label>
                                </div>
                                <div class="tf-field style-1 mb_30">
                                    <input class="tf-field-input tf-input" placeholder="" type="password" id="property4" name="password">
                                    <label class="tf-field-label fw-4 text_black-2" for="property4">Şİfre *</label>
                                </div>
                                <div class="mb_20">
                                    <a href="#recover" class="tf-btn btn-line">Şifrenizi mi unuttunuz?</a>
                                </div>
                                <div class="">
                                    <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Giriş Yap</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tf-login-content">
                    <h5 class="mb_36">Hesabınız yok mu?</h5>
                    <p class="mb_20">Erken Satış erişiminin yanı sıra özel yeni gelenler, trendler ve promosyonlar için kaydolun. Vazgeçmek için e-postalarımızdaki abonelikten çık seçeneğine tıklayın.</p>
                    <a href="{{route('register')}}" class="tf-btn btn-line">Kayıt Ol<i class="icon icon-arrow1-top-left"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
