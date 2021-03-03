<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $lesson_id
 * @property string $date
 *
 * Class LessonAbsentRequest
 * @package App\Http\Requests
 */
class LessonAbsentRequest extends FormRequest
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
            'lesson_id' => ['required', 'integer'],
            'date' => ['required', 'date_format:Y-m-d']
        ];
    }
}
