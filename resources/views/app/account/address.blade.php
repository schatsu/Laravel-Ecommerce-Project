@extends('app.layouts.main')
@section('title', 'Adreslerim')
@section('content')
    <x-page-title-component :name="$name = 'Adreslerim'"/>
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

                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" type="text" name="name" value="{{ old('name', auth()->user()?->name) }}">
                                        <label class="tf-field-label fw-4 text_black-2">Ad</label>
                                        @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" type="text" name="surname" value="{{ old('surname', auth()->user()?->surname) }}">
                                        <label class="tf-field-label fw-4 text_black-2">Soyad</label>
                                        @error('surname') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 company-type-select" name="company_type">
                                            <option value="individual" {{ old('company_type') === 'individual' ? 'selected' : '' }}>Bireysel</option>
                                            <option value="corporate" {{ old('company_type') === 'corporate' ? 'selected' : '' }}>Kurumsal</option>
                                        </select>
                                        @error('company_type') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="individual-fields-wrapper">
                                    <div class="box-field">
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" type="text" name="identity_number" value="{{ old('identity_number') }}">
                                            <label class="tf-field-label fw-4 text_black-2">T.C. Kimlik Numarası</label>
                                            @error('identity_number') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="corporate-fields-wrapper" style="display: none;">
                                    <div class="box-field">
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" type="text" name="company_name" value="{{ old('company_name') }}">
                                            <label class="tf-field-label fw-4 text_black-2">Şirket Adı</label>
                                            @error('company_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="box-field">
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" type="text" name="tax_number" value="{{ old('tax_number') }}">
                                            <label class="tf-field-label fw-4 text_black-2">Vergi Numarası</label>
                                            @error('tax_number') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="box-field">
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" type="text" name="tax_office" value="{{ old('tax_office') }}">
                                            <label class="tf-field-label fw-4 text_black-2">Vergi Dairesi</label>
                                            @error('tax_office') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 country-select" name="country">
                                            @if (isset($countries))
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->slug }}" {{ old('country') == $country->slug ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('country') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 city-select" name="city">
                                            <option value="">İl Seçiniz</option>
                                        </select>
                                        @error('city') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="select-custom">
                                        <select class="tf-select w-100 district-select" name="district">
                                            <option value="">İlçe Seçiniz</option>
                                        </select>
                                        @error('district') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" type="text" name="address" value="{{ old('address') }}">
                                        <label class="tf-field-label fw-4 text_black-2">Adres</label>
                                        @error('address') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field">
                                    <div class="tf-field style-1">
                                        <input class="tf-field-input tf-input" type="text" name="phone" value="{{ old('phone') }}">
                                        <label class="tf-field-label fw-4 text_black-2">Telefon</label>
                                        @error('phone') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="box-field text-start">
                                    <div class="box-checkbox fieldset-radio d-flex align-items-center gap-8">
                                        <input type="checkbox" id="default_invoice_new" name="default_invoice" value="1" class="tf-check" {{ old('default_invoice') ? 'checked' : '' }}>
                                        <label for="default_invoice_new" class="text_black-2 fw-4">Varsayılan fatura adresi olarak ayarla</label>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-20">
                                    <button type="submit" class="tf-btn btn-fill animate-hover-btn">Adresi Kaydet</button>
                                    <span class="tf-btn btn-fill animate-hover-btn btn-hide-address">İptal</span>
                                </div>
                            </form>

                            <div class="list-account-address">
                                @forelse ($address as $item)
                                    <div class="account-address-item {{ $item->default_invoice ? 'default-address' : '' }}" data-id="{{ $item->id }}">
                                        <div class="address-header">
                                            @if($item->default_invoice)
                                                <span style="background-color: #06861f" class="default-badge"><i class="icon icon-check"></i> Varsayılan</span>
                                            @endif
                                            <span class="address-type-badge {{ $item->company_type === 'corporate' ? 'corporate' : 'individual' }}">
                                                {{ $item->company_type === 'corporate' ? 'Kurumsal' : 'Bireysel' }}
                                            </span>
                                        </div>

                                        <div class="address-body">
                                            <h6 class="address-name">{{ $item->name }} {{ $item->surname }}</h6>
                                            @if($item->company_type === 'corporate' && $item->company_name)
                                                <p class="company-info"><i class="icon icon-shop"></i> {{ $item->company_name }}</p>
                                            @endif
                                            <p class="address-text">{{ $item->address }}</p>
                                            <p class="address-location"><i class="icon icon-place"></i> {{ $item->district?->name }} / {{ $item->city?->name }} / {{ $item->country?->name }}</p>
                                            <p class="address-phone"><i class="icon icon-suport"></i> {{ $item->phone }}</p>
                                        </div>

                                        <div class="address-actions">
                                            @if(!$item->default_invoice)
                                                <form method="POST" action="{{ route('account.address.setDefault', $item->slug) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="tf-btn btn-sm btn-outline animate-hover-btn">
                                                        <i class="icon icon-check"></i> Varsayılan Yap
                                                    </button>
                                                </form>
                                            @endif
                                            <button class="tf-btn btn-sm btn-fill animate-hover-btn btn-edit-address">
                                                   Düzenle
                                            </button>
                                            <form method="POST" action="{{ route('account.address.destroy', $item->slug) }}" class="d-inline" onsubmit="return confirm('Bu adresi silmek istediğinize emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="tf-btn btn-sm btn-danger-outline animate-hover-btn">
                                                     Sil
                                                </button>
                                            </form>
                                        </div>

                                        <form class="edit-form-address wd-form-address mt_20 d-none" method="POST"
                                              action="{{route('account.address.update', ['slug' => $item->slug])}}">
                                            @csrf
                                            @method('PUT')

                                            <div class="title">Adresi Düzenle</div>

                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="name" value="{{ old('name', $item->name) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Ad</label>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="surname" value="{{ old('surname', $item->surname) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Soyad</label>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 company-type-select" name="company_type">
                                                        <option value="individual" @selected(old('company_type', $item->company_type) == 'individual')>Bireysel</option>
                                                        <option value="corporate" @selected(old('company_type', $item->company_type) == 'corporate')>Kurumsal</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="individual-fields-wrapper" style="{{ old('company_type', $item->company_type) == 'corporate' ? 'display:none;' : '' }}">
                                                <div class="box-field">
                                                    <div class="tf-field style-1">
                                                        <input class="tf-field-input tf-input" type="text" name="identity_number" value="{{ old('identity_number', $item->identity_number) }}">
                                                        <label class="tf-field-label fw-4 text_black-2">T.C. Kimlik No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="corporate-fields-wrapper" style="{{ old('company_type', $item->company_type) == 'corporate' ? '' : 'display:none;' }}">
                                                <div class="box-field">
                                                    <div class="tf-field style-1">
                                                        <input class="tf-field-input tf-input" type="text" name="company_name" value="{{ old('company_name', $item->company_name) }}">
                                                        <label class="tf-field-label fw-4 text_black-2">Şirket Adı</label>
                                                    </div>
                                                </div>
                                                <div class="box-field">
                                                    <div class="tf-field style-1">
                                                        <input class="tf-field-input tf-input" type="text" name="tax_number" value="{{ old('tax_number', $item->tax_number) }}">
                                                        <label class="tf-field-label fw-4 text_black-2">Vergi Numarası</label>
                                                    </div>
                                                </div>
                                                <div class="box-field">
                                                    <div class="tf-field style-1">
                                                        <input class="tf-field-input tf-input" type="text" name="tax_office" value="{{ old('tax_office', $item->tax_office) }}">
                                                        <label class="tf-field-label fw-4 text_black-2">Vergi Dairesi</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 country-select" name="country">
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country->slug }}" @selected($country->id === $item->country_id)>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 city-select" name="city">
                                                        <option value="{{ $item->city?->slug }}" selected>{{ $item->city?->name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="select-custom">
                                                    <select class="tf-select w-100 district-select" name="district">
                                                        <option value="{{ $item->district?->slug }}" selected>{{ $item->district?->name }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="address" value="{{ old('address', $item->address) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Adres</label>
                                                </div>
                                            </div>

                                            <div class="box-field">
                                                <div class="tf-field style-1">
                                                    <input class="tf-field-input tf-input" type="text" name="phone" value="{{ old('phone', $item->phone) }}">
                                                    <label class="tf-field-label fw-4 text_black-2">Telefon</label>
                                                </div>
                                            </div>

                                            <div class="box-field text-start">
                                                <div class="box-checkbox fieldset-radio d-flex align-items-center gap-8">
                                                    <input type="checkbox" id="default_invoice_edit_{{$item->id}}" name="default_invoice" value="1" class="tf-check" @checked(old('default_invoice', $item->default_invoice))>
                                                    <label for="default_invoice_edit_{{$item->id}}" class="text_black-2 fw-4">Varsayılan fatura adresi olarak ayarla</label>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-center gap-20">
                                                <button type="submit" class="tf-btn btn-fill animate-hover-btn">Güncelle</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.10.0/axios.min.js"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change', '.company-type-select', function () {
                const $form = $(this).closest('form');
                const val = $(this).val();

                if (val === 'corporate') {
                    $form.find('.corporate-fields-wrapper').show();
                    $form.find('.individual-fields-wrapper').hide();
                } else {
                    $form.find('.corporate-fields-wrapper').hide();
                    $form.find('.individual-fields-wrapper').show();
                }
            });

            $(document).on('change', '.country-select', function () {
                const $this = $(this);
                const $form = $this.closest('form');
                const selectedSlug = $this.val();
                const $citySelect = $form.find('.city-select');
                const $districtSelect = $form.find('.district-select');

                if (!selectedSlug) return;

                let url = '{{ route("account.cities", ["countrySlug" => "%%slug%%"]) }}';
                url = url.replace("%%slug%%", encodeURIComponent(selectedSlug));

                axios.get(url)
                    .then(function (response) {
                        const data = response.data.data;

                        $citySelect.empty().append("<option disabled selected>Şehir Seçin</option>");
                        $districtSelect.empty().append("<option disabled selected>İlçe Seçin</option>");

                        $.each(data, function (index, item) {
                            $citySelect.append($('<option>', {
                                value: item.slug,
                                text: item.name
                            }));
                        });
                    })
                    .catch(function (error) {
                        console.error('Şehirler yüklenirken hata oluştu:', error);
                    });
            });

            $(document).on('change', '.city-select', function () {
                const $this = $(this);
                const $form = $this.closest('form');
                const selectedSlug = $this.val();
                const $districtSelect = $form.find('.district-select');

                if (!selectedSlug) return;

                let url = '{{ route("account.districts", ["citySlug" => "%%slug%%"]) }}';
                url = url.replace("%%slug%%", encodeURIComponent(selectedSlug));

                axios.get(url)
                    .then(function (response) {
                        const data = response.data.data;

                        $districtSelect.empty().append("<option disabled selected>İlçe Seçin</option>");

                        $.each(data, function (index, item) {
                            $districtSelect.append($('<option>', {
                                value: item.slug,
                                text: item.name
                            }));
                        });
                    })
                    .catch(function (error) {
                        console.error('İlçeler yüklenirken hata oluştu:', error);
                    });
            });

            $(document).on('click', '.btn-edit-address', function () {
                const $item = $(this).closest('.account-address-item');
                $('.edit-form-address').addClass('d-none');
                $item.find('.edit-form-address').removeClass('d-none');

                $item.find('.company-type-select').trigger('change');
            });

            $(document).on('click', '.btn-cancel-edit', function () {
                $(this).closest('.edit-form-address').addClass('d-none');
            });

            $('.company-type-select').each(function() {
                $(this).trigger('change');
            });
        });
    </script>
@endpush
