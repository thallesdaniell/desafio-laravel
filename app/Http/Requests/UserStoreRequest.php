<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email'                 => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'name'                  => 'sometimes|max:120',
            'password'              => 'required|alpha_num|between:6,20|confirmed',
            'password_confirmation' => 'required|required_with:password|same:password'
        ];
    }
}
