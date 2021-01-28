<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LessonReportRequest
 * @package App\Http\Requests
 */
class LessonReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'lessonId' => ['required', 'integer', 'min:1'],
            'attendance' => ['required', 'integer', 'min:0', 'max:1'],
            'date' => ['required', 'date'],
            'attendance_clients' => ['nullable', 'array'],
            'attendance_clients.*' => ['integer', 'min:0', 'max:1'],
        ];
    }
}
