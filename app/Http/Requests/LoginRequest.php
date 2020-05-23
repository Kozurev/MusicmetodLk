<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();
        $messages['login.required'] = __('validation.required', ['attribute' => __('login.login')]);
        $messages['password.required'] = __('validation.required', ['attribute' => __('login.password')]);
        return $messages;
    }
}
