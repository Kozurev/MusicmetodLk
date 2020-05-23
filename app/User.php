<?php

namespace App;

use App\Api\Facade as Api;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class User
{
    const COOKIE_TOKEN_KEY = 'auth_user_token';
    const REQUEST_TOKEN = 'token';
    const SESSION_USER_DATA = 'auth_user_data';

    /**
     * @var string
     */
    private static $error = '';

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public static function auth(string $login, string $password) : bool
    {
        $response = Api::instance()->auth($login, $password);
        if ($response->token ?? null) {
            Cookie::queue(self::COOKIE_TOKEN_KEY, $response->token, 60*60*24*30);
            return true;
        } else {
            self::setError(__('user.error-' . ($response->errors[0] ?? '')));
            return false;
        }
    }

    public static function logout()
    {
        Cookie::forget(self::COOKIE_TOKEN_KEY);
    }

    /**
     * @return string
     */
    public static function getError() : string
    {
        return self::$error;
    }

    /**
     * @param string $error
     */
    private static function setError(string $error)
    {
        self::$error = $error;
    }

    /**
     * @return string
     */
    public static function getToken() : string
    {
        if (!empty(request()->input(self::REQUEST_TOKEN, ''))) {
            return request()->input(self::REQUEST_TOKEN, '');
        }
        return Cookie::has(self::COOKIE_TOKEN_KEY) ? Cookie::get(self::COOKIE_TOKEN_KEY) : '';
    }

    public static function getByToken(string $token)
    {
        $userData = Api::instance()->getUser(self::getToken());
        if ($userData->error) {
            self::setError($userData->error);
            return null;
        } else {
            return $userData->user;
        }
    }

    /**
     * @return mixed|null
     */
    public static function current()
    {
        if (empty(self::getToken())) {
            return null;
        }
        if (!Session::has(self::SESSION_USER_DATA)) {
            Session::put(self::SESSION_USER_DATA, self::getByToken(self::getToken()));
            Session::save();
        }
        return Session::get(self::SESSION_USER_DATA);
    }

    /**
     *
     */
    public static function fresh()
    {
        Session::remove(self::SESSION_USER_DATA);
    }

    /**
     * @return bool
     */
    public static function isAuth() : bool
    {
        return !empty(self::getToken());
    }

    /**
     * @return \stdClass|null
     */
    public static function getNextLessons()
    {
        $response = Api::instance()->getNearestLessons(self::getToken());
        if (!empty($response->error ?? '')) {
            self::setError($response->error);
            return null;
        } else {
            return $response->nearest;
        }
    }

    /**
     * @param array $params
     * @return \stdClass|null
     */
    public static function getPayments(array $params = [])
    {
        return Api::instance()->getPayments(self::getToken(), $params);
    }

    /**
     * @param array $params
     * @return \stdClass|null
     */
    public static function getReports(array $params = [])
    {
        return Api::instance()->getReports(self::getToken(), $params);
    }

    /**
     * @param array $params
     * @return \stdClass|null
     */
    public static function getSchedule(array $params = [])
    {
        return Api::instance()->getLessons(self::getToken(), $params);
    }

    /**
     * @param int $rateId
     * @return \stdClass|null
     */
    public static function buyRate(int $rateId)
    {
        return Api::instance()->buyRate(self::getToken(), $rateId);
    }

}
