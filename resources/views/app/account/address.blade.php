@extends('app.layouts.main')
@section('title', 'Adreslerim')
@section('content')
    <!-- page-title -->
    <x-page-title-component :name="$name = 'Adreslerim'"/>
    <!-- /page-title -->
    <section class="flat-spacing-11">
        <div class="container">
            <div class="row">
                <x-account-pages-cart-component/>
                <div class="col-lg-9">
                    <div class="my-account-content account-address">
                        <div class="text-center widget-inner-address">
                            <button class="tf-btn btn-fill animate-hover-btn btn-address mb_20">
                                Yeni adres ekle
                            </button>
                            <form class="show-form-address wd-form-address" id="formnewAddress" action="{{route('account.address.store')}}" method="POST">
                                @csrf
                                <div class="title">Yeni adres ekle</div>

                                {{-- Ad --}}
                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="name" name="name" value="{{ old('name') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="name">Ad</label>
                                        @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Soyad --}}
                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="surname" name="surname" value="{{ old('surname') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="surname">Soyad</label>
                                        @error('surname')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Fatura tipi --}}
                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100" id="company_type" name="company_type">
                                            <option value="individual" {{ old('company_type') === 'individual' ? 'selected' : '' }}>Bireysel</option>
                                            <option value="corporate" {{ old('company_type') === 'corporate' ? 'selected' : '' }}>Kurumsal</option>
                                        </select>
                                        @error('company_type')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Bireysel alan --}}
                                <div class="box-field" id="individual-fields">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="identity_number" name="identity_number" value="{{ old('identity_number') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="identity_number">T.C. Kimlik Numarası</label>
                                        @error('identity_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kurumsal alanlar --}}
                                <div class="box-field" id="corporate-fields" style="display: none;">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="company_name" name="company_name" value="{{ old('company_name') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="company_name">Şirket Adı</label>
                                        @error('company_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="tax_number" name="tax_number" value="{{ old('tax_number') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="tax_number">Vergi Numarası</label>
                                        @error('tax_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="tax_office" name="tax_office" value="{{ old('tax_office') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="tax_office">Vergi Dairesi</label>
                                        @error('tax_office')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Ülke --}}
                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 country" id="country" name="country">
                                            @if (isset($countries))
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->slug }}" {{ old('country') == $country->slug ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('country_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- İl --}}
                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 city" id="city" name="city">
                                            <option value="">İl Seçiniz</option>
                                        </select>
                                        @error('city_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- İlçe --}}
                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 district" id="district" name="district">
                                            <option value="">İlçe Seçiniz</option>
                                        </select>
                                        @error('district_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Adres --}}
                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="address" name="address" value="{{ old('address') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="address">Adres</label>
                                        @error('address')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Telefon --}}
                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" placeholder=" " type="text" id="phone" name="phone" value="{{ old('phone') }}">
                                        <label class="tf-field-label fw-4 text_black-2" for="phone">Telefon</label>
                                        @error('phone')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Varsayılan adres kutusu --}}
                                <div class="box-field text-start">
                                    <div class="box-checkbox fieldset-radio d-flex align-items-center gap-8">
                                        <input type="checkbox" id="default_invoice" name="default_invoice" class="tf-check" {{ old('default_invoice') ? 'checked' : '' }}>
                                        <label for="default_invoice" class="text_black-2 fw-4">Varsayılan fatura adresi olarak ayarla</label>
                                    </div>
                                </div>

                                {{-- Butonlar --}}
                                <div class="d-flex align-items-center justify-content-center gap-20">
                                    <button type="submit" class="tf-btn btn-fill animate-hover-btn">Adresi Kaydet</button>
                                    <span class="tf-btn btn-fill animate-hover-btn btn-hide-address">İptal</span>
                                </div>
                            </form>
                            <div class="list-account-address">
                                @forelse ($address as $item)
                                    <div class="account-address-item" data-id="{{ $item->id }}">
                                        @if($item->default_invoice)
                                            <h6 class="mb_20">Varsayılan</h6>
                                        @endif

                                        {{-- Ad Soyad --}}
                                        <p>{{ $item->name }}</p>

                                        {{-- Adres --}}
                                        <p>{{ $item->address }}</p>

                                        {{-- İl / İlçe --}}
                                        <p>{{ $item->district?->name }}, {{ $item->city?->name }}</p>

                                        {{-- Ülke --}}
                                        <p>{{ $item->country?->name }}</p>

                                        {{-- Telefon --}}
                                        <p class="mb_10">{{ $item->phone }}</p>

                                        {{-- Butonlar --}}
                                        <div class="d-flex gap-10 justify-content-center">
                                            <button
                                                class="tf-btn btn-fill animate-hover-btn justify-content-center btn-edit-address"
                                                data-id="{{ $item?->id }}"
                                                data-slug="{{ $item?->slug }}"
                                                data-name="{{ $item?->name }}"
                                                data-surname="{{ $item?->surname }}"
                                                data-address="{{ $item?->address }}"
                                                data-phone="{{ $item?->phone }}"
                                                data-country="{{ $item?->country?->slug }}"
                                                data-city="{{ $item?->city?->slug }}"
                                                data-district="{{ $item?->district?->slug }}"
                                                data-default="{{ $item?->default_invoice ? '1' : '0' }}">
                                                <span>Düzenle</span>
                                            </button>

                                            <form method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="tf-btn btn-outline animate-hover-btn justify-content-center">
                                                    <span>Sil</span>
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Düzenleme Formu --}}
                                        <form class="edit-form-address wd-form-address mt_20 d-none" method="POST"
                                              action="{{route('account.address.update', ['slug' => $item?->slug])}}">
                                            @csrf
                                            @method('PUT')

                                            <div class="title">Adresi Düzenle</div>

                                            {{-- Ad --}}
                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="name" placeholder=" " value="{{ old('name', $item->name) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Ad</label>
                                                    @error('name')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Telefon --}}
                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="phone" placeholder=" " value="{{ old('phone', $item->phone) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Telefon</label>
                                                    @error('phone')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Ülke --}}
                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 country" name="country">
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->slug }}" @selected($country->id === $item->country_id)>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('country')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- İl --}}
                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 city" name="city">
                                                        <option value="{{ $item->city?->slug }}" selected>{{ $item->city?->name }}</option>
                                                    </select>
                                                    @error('city')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- İlçe --}}
                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 district" name="district">
                                                        <option value="{{ $item->district?->slug }}" selected>{{ $item->district?->name }}</option>
                                                    </select>
                                                    @error('district')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- Adres --}}
                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="address" placeholder=" " value="{{ old('address', $item->address) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Adres</label>
                                                    @error('address')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Butonlar --}}
                                            <div class="d-flex align-items-center justify-content-center gap-20">
                                                <button type="submit" class="tf-btn btn-fill animate-hover-btn">Adresi Güncelle</button>
                                                <button type="button" class="tf-btn btn-fill animate-hover-btn btn-cancel-edit">İptal</button>
                                            </div>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-center">Henüz bir adres eklenmemiş.</p>
                                @endforelse
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
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('company_type');
            const individualFields = document.getElementById('individual-fields');
            const corporateFields = document.getElementById('corporate-fields');

            select.addEventListener('change', function () {
                if (this.value === 'corporate') {
                    corporateFields.style.display = 'block';
                    individualFields.style.display = 'none';
                } else {
                    corporateFields.style.display = 'none';
                    individualFields.style.display = 'block';
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.10.0/axios.min.js"></script>
    <script>
        $('.country').on('change', function () {
            const selected = $(this).find(":selected").val();

            let formUrl = '{{route('account.cities', ['countrySlug' => '%%country%%'])}}';
            formUrl = formUrl.replace("%%country%%", encodeURIComponent(selected));

            axios.get(formUrl).then(function (response) {
                const {data} = response.data;
                $('.city').empty().prepend("<option disabled selected='selected'>Şehir Seçin</option>");
                $('.district').empty().prepend("<option disabled selected='selected'>İlçe Seçin</option>");
                {
                    $.each(data, function (index, item) {
                        $('.city').append($('<option>', {
                            value: item['slug'],
                            text: item['name']
                        }));
                    });
                }


            });
        });
        $('.city').on('change', function () {
            const selected = $(this).find(":selected").val();

            let formUrl = '{{route('account.districts', ['citySlug' => '%%city%%'])}}';
            formUrl = formUrl.replace("%%city%%", encodeURIComponent(selected));

            axios.get(formUrl).then(function (response) {
                const {data} = response.data;
                $('.district').empty().prepend("<option disabled selected='selected'>İlçe Seçin</option>");
                $.each(data, function (index, item) {
                    $('.district').append($('<option>', {
                        value: item['slug'],
                        text: item['name']
                    }));
                });
            });
        });
        $(document).ready(function () {
            $('.btn-edit-address').on('click', function () {
                const $wrapper = $(this).closest('.account-address-item');
                $wrapper.find('.edit-form-address').removeClass('d-none');
            });

            $('.btn-cancel-edit').on('click', function () {
                const $form = $(this).closest('.edit-form-address');
                $form.addClass('d-none');
            });
        });


    </script>
@endpush
