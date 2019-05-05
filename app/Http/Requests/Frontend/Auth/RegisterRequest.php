<?php

namespace App\Http\Requests;

use App\Rules\Auth\ChangePassword;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'profile.formal' => ['required', 'array'],
            'profile.formal.company_name' => ['required', 'string', 'min:2', 'max:191'],
            'profile.formal.company_phone' => ['required', 'regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
            'profile.formal.company_email' => ['required', 'email', 'max:191'],
            'profile.formal.company_country' => ['required', 'string', 'min:3', 'max:191'],
            'profile.formal.company_city' => ['required', 'string', 'min:2', 'max:191'],
            'profile.formal.company_address' => ['required', 'string', 'min:3', 'max:191'],
            'profile.formal.company_inn' => ['required', 'digits:10'],
            'profile.formal.company_kpp' => ['required', 'digits:10'],
            //'profile.formal.*' => ['required', 'string', 'min:3', 'max:191'],
            'first_name' => ['required', 'string', 'min:2', 'max:191'],
            'last_name' => ['required', 'string', 'min:2', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'password' => ['required', 'confirmed', new ChangePassword()],
            'g-recaptcha-response' => ['required_if:captcha_status,true', 'captcha'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
            'first_name.required' => __('validation.required', ['attribute' => 'Имя']),
            'first_name.min' => __('validation.min', ['attribute' => 'Имя']),
            'last_name.required' => __('validation.required', ['attribute' => 'Фамилия']),
            'last_name.min' => __('validation.min', ['attribute' => 'Фамилия']),
            'password.confirmed' => __('validation.confirmed', ['attribute' => 'Пароль']),
            'profile.formal.company_name.required' => __('validation.required', ['attribute' => 'Название организации']),
            'profile.formal.company_name.min' => __('validation.min', ['attribute' => 'Название организации']),
            'profile.formal.company_phone.required' => __('validation.required', ['attribute' => 'Телефон']),
            'profile.formal.company_phone.regex' => __('validation.regex', ['attribute' => 'Телефон']),
            'profile.formal.company_email.required' =>__('validation.required', ['attribute' => 'E-mail']),
            'profile.formal.company_email.email' =>__('validation.email', ['attribute' => 'E-mail']),
            'profile.formal.company_country.required' => __('validation.required', ['attribute' => 'Страна']),
            'profile.formal.company_country.min' => __('validation.min', ['attribute' => 'Страна']),
            'profile.formal.company_city.required' => __('validation.required', ['attribute' => 'Город']),
            'profile.formal.company_city.min' => __('validation.min', ['attribute' => 'Город']),
            'profile.formal.company_address.required' => __('validation.required', ['attribute' => 'Адрес']),
            'profile.formal.company_address.min' => __('validation.min', ['attribute' => 'Адрес']),
            'profile.formal.company_inn.required' => __('validation.required', ['attribute' => 'ИНН']),
            'profile.formal.company_inn.digits' => __('validation.digits', ['attribute' => 'ИНН']),
            'profile.formal.company_kpp.required' => __('validation.required', ['attribute' => 'КПП']),
            'profile.formal.company_kpp.digits' => __('validation.digits', ['attribute' => 'КПП']),
        ];
    }
}
