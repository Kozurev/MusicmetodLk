<?php

namespace App\Http\Controllers;

use App\Api\ApiResponse;
use App\Http\Requests\ProfileUpdateRequest;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Api\Facade as Api;

class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('profile');
    }

    public function save(ProfileUpdateRequest $request): RedirectResponse
    {
        $profileData = [
            Api::PARAM_USER_FIRST_NAME => $request->surname,
            Api::PARAM_USER_LAST_NAME => $request->name,
            Api::PARAM_USER_PHONE_NUMBER => $request->phone_number,
            Api::PARAM_USER_EMAIL => $request->email,
        ];
        if (!empty($request->password_old) && !empty($request->password)) {
            $profileData = array_merge([Api::PARAM_USER_PASSWORD_OLD => $request->password_old,
                Api::PARAM_USER_PASSWORD => $request->password,
                Api::PARAM_USER_PASSWORD_CONFIRMATION => $request->password_confirmation
            ], $profileData);
        }
        $apiResponse = Api::instance()->saveProfile(User::getToken(), $profileData);

        $response = redirect()->back();
        if ($apiResponse->hasErrors()) {
            if ($apiResponse->getErrorCode() === ApiResponse::ERROR_CODE_PASSWORD_CONFIRMATION) {
                $errorTag = 'password';
            } elseif ($apiResponse->getErrorCode() === ApiResponse::ERROR_CODE_PASSWORD_OLD) {
                $errorTag = 'password_old';
            } elseif (trim($apiResponse->getErrorMessage()) == 'Пользователь с таким email уже существует') { //Вот такой костыль для отлова ошибки именно дублирования email-а
                $errorTag = 'email';
            } else {
                $errorTag = 'api';
            }
            $response->withErrors([$errorTag => $apiResponse->getErrorMessage()]);
        } else {
            $response->with('success', __('profile.update_success'));
        }
        return $response;
    }
}
