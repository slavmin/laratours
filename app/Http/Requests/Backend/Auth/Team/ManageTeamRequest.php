<?php

namespace App\Http\Requests\Backend\Auth\Team;

use App\Models\Auth\Team;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManageTeamRequest.
 */
class ManageTeamRequest extends FormRequest
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
        return [
            //
        ];
    }
}
