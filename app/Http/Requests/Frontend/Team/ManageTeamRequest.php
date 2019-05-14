<?php


namespace App\Http\Requests\Frontend\Team;

use App\Models\Auth\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManageTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isTeamOwner();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $team = Team::where('id', $this->team_id)->first();

        if($this->input('profile_type')){
            return [
                //'profile.formal' => ['required', 'array'],
                'profile.*.company_name' => ['required', 'string', 'min:2', 'max:191', Rule::unique('teams', 'name')->ignore($team)],
                'profile.*.company_phone' => ['required', 'regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
                'profile.*.company_email' => ['required', 'email', 'max:191'],
                'profile.*.company_country' => ['required', 'string', 'min:3', 'max:191'],
                'profile.*.company_city' => ['required', 'string', 'min:2', 'max:191'],
                'profile.*.company_address' => ['required', 'string', 'min:3', 'max:191'],
                'profile.*.company_inn' => ['required', 'digits:10'],
                'profile.*.company_kpp' => ['required', 'digits:9'],
            ];
        } else {
            return [
                'email' => ['required', 'string', 'email', 'max:191'],
            ];
        }

    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'profile.*.company_name.unique' => __('validation.unique', ['attribute' => 'Название организации']),
            'profile.*.company_name.required' => __('validation.required', ['attribute' => 'Название организации']),
            'profile.*.company_name.min' => __('validation.min', ['attribute' => 'Название организации']),
            'profile.*.company_phone.required' => __('validation.required', ['attribute' => 'Телефон']),
            'profile.*.company_phone.regex' => __('validation.regex', ['attribute' => 'Телефон']),
            'profile.*.company_email.required' =>__('validation.required', ['attribute' => 'E-mail']),
            'profile.*.company_email.email' =>__('validation.email', ['attribute' => 'E-mail']),
            'profile.*.company_country.required' => __('validation.required', ['attribute' => 'Страна']),
            'profile.*.company_country.min' => __('validation.min', ['attribute' => 'Страна']),
            'profile.*.company_city.required' => __('validation.required', ['attribute' => 'Город']),
            'profile.*.company_city.min' => __('validation.min', ['attribute' => 'Город']),
            'profile.*.company_address.required' => __('validation.required', ['attribute' => 'Адрес']),
            'profile.*.company_address.min' => __('validation.min', ['attribute' => 'Адрес']),
            'profile.*.company_inn.required' => __('validation.required', ['attribute' => 'ИНН']),
            'profile.*.company_inn.digits' => __('validation.digits', ['attribute' => 'ИНН']),
            'profile.*.company_kpp.required' => __('validation.required', ['attribute' => 'КПП']),
            'profile.*.company_kpp.digits' => __('validation.digits', ['attribute' => 'КПП']),
        ];
    }

}