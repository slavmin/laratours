<?php

namespace App\Http\Requests\Backend\Auth\Team;

use App\Models\Auth\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateTeamRequest.
 */
class UpdateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->input('profile_type') == 'formal'){
            return [
                //'profile.formal' => ['required', 'array'],
                'profile.formal.company_name' => ['required', 'string', 'min:2', 'max:191', Rule::unique('teams', 'name')->ignore($this->team)],
                'profile.formal.company_phone' => ['required', 'regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
                'profile.formal.company_email' => ['required', 'email', 'max:191'],
                'profile.formal.company_country' => ['required', 'string', 'min:3', 'max:191'],
                'profile.formal.company_city' => ['required', 'string', 'min:2', 'max:191'],
                'profile.formal.company_address' => ['required', 'string', 'min:3', 'max:191'],
                'profile.formal.company_inn' => ['required', 'digits:10'],
                'profile.formal.company_kpp' => ['required', 'digits:10'],
            ];
        } else {
            return [
                //'profile.real' => ['required', 'array'],
                'profile.real.company_name' => ['required', 'string', 'min:2', 'max:191', Rule::unique('teams', 'name')->ignore($this->team)],
                'profile.real.company_phone' => ['required', 'regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
                'profile.real.company_email' => ['required', 'email', 'max:191'],
                'profile.real.company_country' => ['required', 'string', 'min:3', 'max:191'],
                'profile.real.company_city' => ['required', 'string', 'min:2', 'max:191'],
                'profile.real.company_address' => ['required', 'string', 'min:3', 'max:191'],
                'profile.real.company_inn' => ['required', 'digits:10'],
                'profile.real.company_kpp' => ['required', 'digits:10'],
            ];
        }
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'profile.formal.company_name.unique' => __('validation.unique', ['attribute' => 'Название организации']),
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
            //---------------------
            'profile.real.company_name.unique' => __('validation.unique', ['attribute' => 'Название организации']),
            'profile.real.company_name.required' => __('validation.required', ['attribute' => 'Название организации']),
            'profile.real.company_name.min' => __('validation.min', ['attribute' => 'Название организации']),
            'profile.real.company_phone.required' => __('validation.required', ['attribute' => 'Телефон']),
            'profile.real.company_phone.regex' => __('validation.regex', ['attribute' => 'Телефон']),
            'profile.real.company_email.required' =>__('validation.required', ['attribute' => 'E-mail']),
            'profile.real.company_email.email' =>__('validation.email', ['attribute' => 'E-mail']),
            'profile.real.company_country.required' => __('validation.required', ['attribute' => 'Страна']),
            'profile.real.company_country.min' => __('validation.min', ['attribute' => 'Страна']),
            'profile.real.company_city.required' => __('validation.required', ['attribute' => 'Город']),
            'profile.real.company_city.min' => __('validation.min', ['attribute' => 'Город']),
            'profile.real.company_address.required' => __('validation.required', ['attribute' => 'Адрес']),
            'profile.real.company_address.min' => __('validation.min', ['attribute' => 'Адрес']),
            'profile.real.company_inn.required' => __('validation.required', ['attribute' => 'ИНН']),
            'profile.real.company_inn.digits' => __('validation.digits', ['attribute' => 'ИНН']),
            'profile.real.company_kpp.required' => __('validation.required', ['attribute' => 'КПП']),
            'profile.real.company_kpp.digits' => __('validation.digits', ['attribute' => 'КПП']),
        ];
    }
}
