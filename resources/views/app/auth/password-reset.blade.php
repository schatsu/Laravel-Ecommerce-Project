@extends('app.layouts.main')
@section('title', 'Şifrenizi Sıfırlayın')
@section('content')
    <!-- page-title -->
    <div class="tf-page-title style-2">
        <div class="container-full">
            <div class="heading text-center">Şifrenizi Sıfırlayın</div>
        </div>
    </div>
    <!-- /page-title -->
    <section class="flat-spacing-10">
        <div class="container">
            <div class="tf-grid-layout lg-col-2 tf-password-reset-wrap">
                <div class="tf-password-reset-form">
                    <div id="password-reset">
                        <h5 class="mb_36">Şifrenizi Sıfırlayın</h5>
                        <div>
                            <form id="login-form" action="{{route('password.update')}}" accept-charset="utf-8" method="post">
                                @csrf
                                <input type="hidden" name="token" value="{{$token ?? ''}}">
                                <input type="hidden" name="email" value="{{$email ?? ''}}">
                                <div class="tf-field style-1 mb_15">
                                    <div class="tf-field style-1 mb_15">
                                        <input class="tf-field-input tf-input" placeholder="" type="password" id="property3" name="password">
                                        <label class="tf-field-label fw-4 text_black-2" for="property3">Yeni Şifre *</label>

                                        @error('password')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tf-field style-1 mb_30">
                                    <input class="tf-field-input tf-input" placeholder="" type="password" id="property4" name="password_confirmation">
                                    <label class="tf-field-label fw-4 text_black-2" for="property4">Yeni Şifre Tekrarı *</label>

                                    @error('password_confirmation')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="">
                                    <button type="submit" class="tf-btn w-100 radius-3 btn-fill animate-hover-btn justify-content-center">Şifrenizi Sıfırlayın</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tf-password-reset-content">
                    <h5 class="mb_36">Hesabınız yok mu?</h5>
                    <p class="mb_20">Erken Satış erişiminin yanı sıra özel yeni gelenler, trendler ve promosyonlar için kaydolun. Vazgeçmek için e-postalarımızdaki abonelikten çık seçeneğine tıklayın.</p>
                    <a href="{{route('register')}}" class="tf-btn btn-line">Kayıt Ol<i class="icon icon-arrow1-top-left"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
