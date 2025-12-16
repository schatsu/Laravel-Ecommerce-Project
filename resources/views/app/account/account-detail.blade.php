@extends('app.layouts.main')
@section('title', 'Hesap Detaylarım')

@push('css')
<style>
    .password-field-wrapper {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 18px;
        transition: color 0.2s ease;
        z-index: 10;
    }
    .password-toggle:hover {
        color: #333;
    }
    .password-field-wrapper .tf-field-input {
        padding-right: 45px;
    }
</style>
@endpush

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
                            <form class="" id="form-account-update" action="{{ route('account.details.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder=" " type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                                    <label class="tf-field-label fw-4 text_black-2" for="name">Ad</label>
                                    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder=" " type="text" id="surname" name="surname" value="{{ old('surname', $user->surname) }}">
                                    <label class="tf-field-label fw-4 text_black-2" for="surname">Soyad</label>
                                    @error('surname') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder=" " type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
                                    <label class="tf-field-label fw-4 text_black-2" for="email">E-Posta</label>
                                    @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="tf-field style-1 mb_15">
                                    <input class="tf-field-input tf-input" placeholder=" " type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    <label class="tf-field-label fw-4 text_black-2" for="phone">Telefon</label>
                                    @error('phone') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <hr class="my-4">

                                <h6 class="mb_20">Şifre Değişikliği</h6>

                                <div class="tf-field style-1 mb_30 password-field-wrapper">
                                    <input class="tf-field-input tf-input" placeholder=" " type="password" id="current_password" name="current_password">
                                    <label class="tf-field-label fw-4 text_black-2" for="current_password">Mevcut Şifre</label>
                                    <span class="password-toggle" data-target="current_password">
                                        <i class="icon icon-view"></i>
                                    </span>
                                    @error('current_password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="tf-field style-1 mb_30 password-field-wrapper">
                                    <input class="tf-field-input tf-input" placeholder=" " type="password" id="password" name="password">
                                    <label class="tf-field-label fw-4 text_black-2" for="password">Yeni Şifre</label>
                                    <span class="password-toggle" data-target="password">
                                        <i class="icon icon-view"></i>
                                    </span>
                                    @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="tf-field style-1 mb_30 password-field-wrapper">
                                    <input class="tf-field-input tf-input" placeholder=" " type="password" id="password_confirmation" name="password_confirmation">
                                    <label class="tf-field-label fw-4 text_black-2" for="password_confirmation">Yeni Şifre Tekrarı</label>
                                    <span class="password-toggle" data-target="password_confirmation">
                                        <i class="icon icon-view"></i>
                                    </span>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('.password-toggle').on('click', function() {
            const targetId = $(this).data('target');
            const $input = $('#' + targetId);
            const $icon = $(this).find('i');

            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.removeClass('icon-view').addClass('icon-close');
            } else {
                $input.attr('type', 'password');
                $icon.removeClass('icon-close').addClass('icon-view');
            }
        });
    });
</script>
@endpush
