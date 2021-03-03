<?php

namespace App\Http\Requests;

use App\Api\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonSaveTeacherRequest extends FormRequest
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
            'type_id' => ['required', 'integer', Rule::in([Schedule::TYPE_SINGLE, Schedule::TYPE_PRIVATE])],
            'client_id' => ['required', 'integer'],
            'area_id' => ['required', 'integer', 'min:1'],
            'class_id' => ['required', 'integer', 'min:1'],
            'date' => ['required' , 'date_format:Y-m-d'],
            'lesson_time_from' => ['required', 'string', 'date_format:H:i'],
            'lesson_time_to' => ['required', 'string', 'date_format:H:i'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $messages = parent::messages();
        $messages['time.required'] = __('pages.make-lesson-time-required');
        $messages['time.date_format'] = __('pages.make-lesson-time-format');
        $messages['date.required'] = __('pages.make-lesson-date-required');
        $messages['date.date_format'] = __('pages.make-lesson-date-format');
        $messages['client_id.required'] = __('pages.make-lesson-client-id-required');
        $messages['client_id.min'] = __('pages.make-lesson-client-id-required');
        $messages['area_id.required'] = __('pages.make-lesson-area-id-required');
        $messages['area_id.min'] = __('pages.make-lesson-area-id-required');
        $messages['lesson_time_from.required'] = __('pages.make-lesson-time-from-required');
        $messages['lesson_time_from.date_format'] = __('pages.make-lesson-time-from-required');
        $messages['lesson_time_to.required'] = __('pages.make-lesson-time-to-required');
        $messages['lesson_time_to.date_format'] = __('pages.make-lesson-time-to-required');
        return $messages;
    }
}
