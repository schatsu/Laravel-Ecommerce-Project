<?php

namespace App\Http\Requests\Front;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:60',
            'company_type' => 'required|in:individual,corporate',

            'identity_number' => 'required_if:company_type,individual|string|size:11',

            'company_name' => 'required_if:company_type,corporate|string|max:255',
            'tax_number' => 'required_if:company_type,corporate|string|max:20',
            'tax_office' => 'required_if:company_type,corporate|string|max:100',

            'phone' => 'required|string|unique:users,phone',

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
            'name.min' => 'Ad en az :min karakter olmalıdır.',
            'name.max' => 'Ad en fazla :max karakter olabilir.',

            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.min' => 'Soyad en az :min karakter olmalıdır.',
            'surname.max' => 'Soyad en fazla :max karakter olabilir.',

            'company_type.required' => 'Fatura tipi seçilmelidir.',
            'company_type.in' => 'Geçerli bir fatura tipi seçiniz.',

            'identity_number.required_if' => 'T.C. kimlik numarası bireysel kullanıcılar için zorunludur.',
            'identity_number.size' => 'T.C. kimlik numarası 11 haneli olmalıdır.',

            'company_name.required_if' => 'Şirket adı kurumsal kullanıcılar için zorunludur.',
            'tax_number.required_if' => 'Vergi numarası kurumsal kullanıcılar için zorunludur.',
            'tax_office.required_if' => 'Vergi dairesi kurumsal kullanıcılar için zorunludur.',

            'phone.required' => 'Telefon numarası zorunludur.',
            'phone.unique' => 'Bu telefon numarası zaten kayıtlı.',

            'country_id.required' => 'Ülke seçilmelidir.',
            'country_id.exists' => 'Geçerli bir ülke seçiniz.',

            'city_id.required' => 'İl seçilmelidir.',
            'city_id.exists' => 'Geçerli bir il seçiniz.',

            'district_id.required' => 'İlçe seçilmelidir.',
            'district_id.exists' => 'Geçerli bir ilçe seçiniz.',

            'address.required' => 'Adres alanı zorunludur.',
            'address.min' => 'Adres en az :min karakter olmalıdır.',
            'address.max' => 'Adres en fazla :max karakter olabilir.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $country = Country::query()->select('id')->where('slug', $this?->country)->first();
        $city = City::query()->select('id')->where('slug', $this?->city)->first();
        $district = District::query()->select('id')->where('slug', $this?->district)->first();

        $this->merge([
            'country_id' => $country?->id,
            'city_id' => $city?->id,
            'district_id' => $district?->id,
        ]);
    }

}
