<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Изменение основных данных профиля игрока
 *
 * @property string $surname
 * @property string|null $name
 * @property string|null $phone_number
 * @property string|null $email
 * @property string|null $password_old
 * @property string|null $password
 * @property string|null $password_confirmation
 *
 * Class ProfileUpdateRequest
 * @package App\Http\Requests
 */
class ProfileUpdateRequest extends FormRequest
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
            'surname'       => ['required', 'max:255', 'regex:/^[А-Яа-яA-Za-z\s_-]+$/u'],
            'name'          => ['nullable', 'max:255', 'regex:/^[А-Яа-яA-Za-z\s_-]+$/u'],
            'phone_number'  => ['nullable', 'regex:/(\+7)[0-9]{10}/'],
            'email'         => ['nullable', 'email'],
            'password'      => ['nullable', 'confirmed']
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        $messages = parent::messages();
        $messages['surname.regex'] = __('profile.error_first_name_regex');
        $messages['name.regex'] = __('profile.error_last_name_regex');
        $messages['hone_number.regex'] = __('profile.error_phone_number_regex');
        $messages['email.email'] = __('profile.error_email_regex');
        $messages['password.confirmed'] = __('profile.error_password_confirmed');
        return $messages;
    }
}
