<?php

namespace App\Http\Requests\Front;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:60',
            'surname' => 'required|string|min:2|max:60',

            'company_type' => 'required|in:individual,corporate',

            'identity_number' => 'required_if:company_type,individual|nullable|string|size:11',

            'company_name' => 'required_if:company_type,corporate|nullable|string|max:255',
            'tax_number' => 'required_if:company_type,corporate|nullable|string|max:20',
            'tax_office' => 'required_if:company_type,corporate|nullable|string|max:100',

            'phone' => 'required|string|max:20',

            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',

            'address' => 'required|string|min:5|max:255',

            'default_invoice' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'company_type.required' => 'Fatura tipi seçilmelidir.',
            'identity_number.required_if' => 'Bireysel seçimde T.C. Kimlik No zorunludur.',
            'identity_number.size' => 'T.C. Kimlik No 11 haneli olmalıdır.',
            'company_name.required_if' => 'Kurumsal seçimde Şirket Adı zorunludur.',
            'tax_number.required_if' => 'Vergi Numarası zorunludur.',
            'tax_office.required_if' => 'Vergi Dairesi zorunludur.',
            'country_id.required' => 'Lütfen bir ülke seçiniz.',
            'city_id.required' => 'Lütfen bir il seçiniz.',
            'district_id.required' => 'Lütfen bir ilçe seçiniz.',
            'address.required' => 'Adres detayını giriniz.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $countryId = null;
        $cityId = null;
        $districtId = null;

        if ($this->country) {
            $countryId = Country::where('slug', $this->country)->value('id');
        }
        if ($this->city) {
            $cityId = City::where('slug', $this->city)->value('id');
        }
        if ($this->district) {
            $districtId = District::where('slug', $this->district)->value('id');
        }

        $this->merge([
            'country_id' => $countryId,
            'city_id'     => $cityId,
            'district_id' => $districtId,
            'default_invoice' => $this->has('default_invoice'),
        ]);
    }
}
