<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
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
            'email' => 'required|email',
            'name'  => 'required|string',
            'phone' => Rule::requiredIf(function () {
                $return = false;
                if (!$this->phones) return false;
                foreach ($this->phones as $phones) {
                    $sum = preg_replace('/[^0-9]/', '', $phones);
                    if (strlen($sum) == 11) continue;
                    $return = true;
                }
                return $return;
            }),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {

        return [
            'phone.required' => 'Telefone informado não é válido!'
        ];
    }
}
