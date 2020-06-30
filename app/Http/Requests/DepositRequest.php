<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
            'amount' => 'required|integer|min:100',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages['amount.required'] = __('pages.error-deposit-amount-required');
        $messages['amount.min'] = __('pages.error-deposit-amount-min', ['min' => 100]);
        return $messages;
    }

}
