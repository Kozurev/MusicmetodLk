<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsentPeriodSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();
        $messages['date_from.required'] = __('pages.absent-period-date-from-required');
        $messages['date_to.required'] = __('pages.absent-period-date-to-required');
        return $messages;
    }
}
