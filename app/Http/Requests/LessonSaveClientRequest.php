<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonSaveClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|string|min:1',
            'teacherId' => 'required|integer|min:1'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $messages = parent::messages();
        $messages['time.required'] = __('pages.make-lesson-time-required');
        $messages['time.min'] = __('pages.make-lesson-time-min');
        $messages['time.date_format'] = __('pages.make-lesson-time-format');
        $messages['date.required'] = __('pages.make-lesson-date-required');
        $messages['date.date_format'] = __('pages.make-lesson-date-format');
        return $messages;
    }

}
