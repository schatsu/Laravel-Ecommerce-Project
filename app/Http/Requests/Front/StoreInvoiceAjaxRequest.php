<?php

namespace App\Http\Requests\Front;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInvoiceAjaxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     */
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
            'city_id' => $cityId,
            'district_id' => $districtId,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:delivery,billing',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'identity_number' => 'nullable|string|size:11',
            'company_type' => 'nullable|in:individual,corporate',
            'company_name' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'tax_office' => 'nullable|string|max:255',
            'default_delivery' => 'nullable|boolean',
            'default_billing' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Adres tipi seçilmelidir.',
            'type.in' => 'Geçersiz adres tipi.',
            'name.required' => 'Ad alanı zorunludur.',
            'name.string' => 'Ad alanı metin olmalıdır.',
            'name.max' => 'Ad alanı en fazla 255 karakter olabilir.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.string' => 'Soyad alanı metin olmalıdır.',
            'surname.max' => 'Soyad alanı en fazla 255 karakter olabilir.',
            'phone.required' => 'Telefon numarası zorunludur.',
            'phone.string' => 'Telefon numarası metin olmalıdır.',
            'phone.max' => 'Telefon numarası en fazla 20 karakter olabilir.',
            'address.required' => 'Açık adres zorunludur.',
            'address.string' => 'Açık adres metin olmalıdır.',
            'country_id.required' => 'Ülke seçilmelidir.',
            'country_id.exists' => 'Seçilen ülke geçersiz.',
            'city_id.required' => 'İl seçilmelidir.',
            'city_id.exists' => 'Seçilen il geçersiz.',
            'district_id.required' => 'İlçe seçilmelidir.',
            'district_id.exists' => 'Seçilen ilçe geçersiz.',
            'identity_number.string' => 'T.C. Kimlik numarası metin olmalıdır.',
            'identity_number.size' => 'T.C. Kimlik numarası 11 haneli olmalıdır.',
            'company_type.in' => 'Geçersiz şirket tipi.',
            'company_name.string' => 'Şirket adı metin olmalıdır.',
            'company_name.max' => 'Şirket adı en fazla 255 karakter olabilir.',
            'tax_number.string' => 'Vergi numarası metin olmalıdır.',
            'tax_number.max' => 'Vergi numarası en fazla 50 karakter olabilir.',
            'tax_office.string' => 'Vergi dairesi metin olmalıdır.',
            'tax_office.max' => 'Vergi dairesi en fazla 255 karakter olabilir.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'type' => 'adres tipi',
            'name' => 'ad',
            'surname' => 'soyad',
            'phone' => 'telefon',
            'address' => 'açık adres',
            'country_id' => 'ülke',
            'city_id' => 'il',
            'district_id' => 'ilçe',
            'identity_number' => 'T.C. kimlik numarası',
            'company_type' => 'şirket tipi',
            'company_name' => 'şirket adı',
            'tax_number' => 'vergi numarası',
            'tax_office' => 'vergi dairesi',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Doğrulama hatası.',
            'errors' => $validator->errors(),
        ], 422));
    }
}

