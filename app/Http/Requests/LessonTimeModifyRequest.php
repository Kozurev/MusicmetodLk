<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $lesson_id
 * @property string $date
 * @property string $time_from
 * @property string $time_to
 *
 * Class LessonTimeModifyRequest
 * @package App\Http\Requests
 */
class LessonTimeModifyRequest extends FormRequest
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
            'lesson_id' => ['required', 'integer', 'min:1'],
            'date'      => ['required', 'date_format:Y-m-d'],
            'time_from' => ['required', 'date_format:H:i'],
            'time_to'   => ['required', 'date_format:H:i']
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $messages = parent::messages();
        $messages['date.required'] =        __('pages.make-lesson-date-required');
        $messages['date.format'] =          __('pages.make-lesson-date-format');
        $messages['time_from.required'] =   __('pages.make-lesson-time-from-required');
        $messages['time_from.date_format']= __('pages.make-lesson-time-from-required');
        $messages['time_to.required'] =     __('pages.make-lesson-time-to-required');
        $messages['time_to.date_format'] =  __('pages.make-lesson-time-to-required');
        return $messages;
    }
}
