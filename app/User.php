<?php

namespace App;

use App\Api\ApiResponse;
use App\Api\Facade as Api;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class User
{
    const COOKIE_TOKEN_KEY = 'auth_user_token';
    const REQUEST_TOKEN = 'token';
    const SESSION_USER_DATA = 'auth_user_data';

    const ROLE_TEACHER = 4;
    const ROLE_CLIENT = 5;

    /**
     * @var array|string[]
     */
    protected static array $rolesTags = [
        self::ROLE_TEACHER => 'teacher',
        self::ROLE_CLIENT => 'client'
    ];

    /**
     * @var string
     */
    private static string $error = '';

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public static function auth(string $login, string $password): bool
    {
        $response = Api::instance()->auth($login, $password);
        if ($response->data()->get('token')) {
            self::storeAuthToken($response->data()->get('token'));
            return true;
        } else {
            self::setError(__('user.error-' . ($response->data()->get('errors')[0] ?? '')));
            return false;
        }
    }

    /**
     * Сохранение авторизационного токена
     *
     * @param string $token
     */
    public static function storeAuthToken(string $token): void
    {
        Cookie::queue(self::COOKIE_TOKEN_KEY, $token, 60*60*24*30);
    }

    /**
     * Выход из учетной записи
     */
    public static function logout(): void
    {
        Cookie::queue(Cookie::forget(self::COOKIE_TOKEN_KEY));
    }

    /**
     * @return string
     */
    public static function getError(): string
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
    public static function getToken(): string
    {
        $requestToken = request()->input(self::REQUEST_TOKEN, null);
        if (!empty($requestToken)) {
            self::storeAuthToken($requestToken);
            return $requestToken;
        }
        return Cookie::has(self::COOKIE_TOKEN_KEY) ? Cookie::get(self::COOKIE_TOKEN_KEY) : '';
    }

    /**
     * @param string $token
     * @return \stdClass|null
     */
    public static function getByToken(string $token): ?\stdClass
    {
        $userData = Api::instance()->getUser($token);
        if (is_null($userData)) {
            return null;
        }
        if ($userData->error ?? null) {
            self::setError($userData->error);
            return null;
        } else {
            $user = $userData->user;
            $user->group = self::getRoleTag($user->group_id);
            return $userData->user;
        }
    }

    /**
     * @return mixed|null
     */
    public static function current(): ?\stdClass
    {
        if (empty(self::getToken())) {
            return null;
        }
        if (!session()->has(self::SESSION_USER_DATA)) {
            $user = self::getByToken(self::getToken());
            if (is_null($user)) {
                self::logout();
                return null;
            }
            session()->put(self::SESSION_USER_DATA, $user);
        }
        return session()->get(self::SESSION_USER_DATA);
    }

    /**
     * Очистка кэша данных пользователя
     */
    public static function fresh()
    {
        Session::remove(self::SESSION_USER_DATA);
    }

    /**
     * Проверка на авторизацию
     *
     * @return bool
     */
    public static function isAuth(): bool
    {
        return !empty(self::current());
    }

    /**
     * @return bool
     */
    public static function isClient(): bool
    {
        return (self::current()->group_id ?? null) == self::ROLE_CLIENT;
    }

    /**
     * @return bool
     */
    public static function isTeacher(): bool
    {
        return (self::current()->group_id ?? null) == self::ROLE_TEACHER;
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
     * @return array
     */
    public static function getPayments(array $params = []) : array
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
     * @return Collection
     * @throws \Exception
     */
    public static function getScheduleShort(array $params = []): Collection
    {
        $response = Api::instance()->getScheduleShort(self::getToken(), $params);
        if ($response->hasErrors()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->data();
    }

    /**
     * @param int $areaId
     * @param string $date
     * @return Collection
     * @throws \Exception
     */
    public static function getScheduleFull(int $areaId, string $date): Collection
    {
        $response = Api::instance()->getScheduleFull(self::getToken(), $areaId, $date);
        if ($response->hasErrors()) {
            throw new \Exception($response->getErrorMessage());
        }
        return $response->data();
    }

    /**
     * @param array $params
     * @return array
     */
    public static function getTeacherScheduleStatistic(array $params = []) : array
    {
        return Api::instance()->getTeacherScheduleStatistic(self::getToken(), $params);
    }

    /**
     * @param int $rateId
     * @return \stdClass|null
     */
    public static function buyRate(int $rateId)
    {
        return Api::instance()->buyRate(self::getToken(), $rateId);
    }

    /**
     * @param int $amount
     * @return \stdClass|null
     */
    public static function makeDeposit(int $amount)
    {
        $successUrl = route('balance.depositSuccess', ['amount' => $amount]);
        $errorUrl = route('balance.depositError');
        return Api::instance()->makeDeposit(self::getToken(), $amount, null, $successUrl, $errorUrl);
    }

    /**
     * @return \stdClass|null
     */
    public static function getTeachers(): ?\stdClass
    {
        return Api::instance()->getTeachers(self::getToken());
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public static function getClients(): Collection
    {
        $response = Api::instance()->getClients(self::getToken());
        if ($response->hasErrors()) {
            throw new \Exception($response->getErrorMessage(), $response->getErrorCode());
        }
        return collect($response->data()->get('clients'));
    }

    /**
     * @param int $teacherId
     * @return \stdClass|null
     */
    public static function getTeacherSchedule(int $teacherId)
    {
        return Api::instance()->getTeacherSchedule(self::getToken(), $teacherId);
    }

    /**
     * @param int $teacherId
     * @param string $date
     * @return \stdClass|null
     */
    public static function getTeacherNearestTime(int $teacherId, string $date)
    {
        return Api::instance()->getTeacherNearestTime(self::getToken(), $teacherId, $date, self::current()->lessonDuration);
    }

    /**
     * @param array $lessonData
     * @return ApiResponse
     */
    public static function lessonSave(array $lessonData): ApiResponse
    {
        if (self::isClient()) {
            $lessonData[\App\Api\Schedule::PARAM_LESSON_CLIENT_ID] = self::current()->id;
        } elseif (self::isTeacher()) {
            $lessonData[\App\Api\Schedule::PARAM_LESSON_TEACHER_ID] = self::current()->id;
        }

        return Api::instance()->lessonSave(self::getToken(), $lessonData);
    }

    /**
     * @param int $lessonId
     * @param string $date
     * @param string $timeFrom
     * @param string $timeTo
     * @throws \Exception
     */
    public static function lessonTimeModify(int $lessonId, string $date, string $timeFrom, string $timeTo): void
    {
        $response = Api::instance()->lessonTimeModify(self::getToken(), $lessonId, $date, $timeFrom, $timeTo);
        if ($response->hasErrors()) {
            throw new \Exception($response->getErrorMessage());
        }
    }

    /**
     * @param int $lessonId
     * @param string $date
     * @throws \Exception
     */
    public static function lessonAbsent(int $lessonId, string $date): void
    {
        $response = Api::instance()->lessonAbsent(self::getToken(), $lessonId, $date);
        if ($response->hasErrors()) {
            throw new \Exception($response->getErrorMessage());
        }
    }

    /**
     * @param array $params
     * @return \stdClass|null
     */
    public static function getAbsentPeriods(array $params = [])
    {
        return Api::instance()->getAbsentPeriods(self::getToken(), $params);
    }

    /**
     * @param array $params
     * @return \stdClass|null
     */
    public static function saveAbsentPeriod(array $params = [])
    {
        return Api::instance()->saveAbsentPeriod(self::getToken(), $params);
    }

    /**
     * @param int $id
     * @return \stdClass|null
     */
    public static function deleteAbsentPeriod(int $id)
    {
        return Api::instance()->deleteAbsentPeriod(self::getToken(), $id);
    }

    /**
     * @return Collection
     */
    public static function getAreas(): Collection
    {
        return collect(Api::instance()->getAreas(self::getToken()));
    }

    /**
     * @param int|null $role
     * @return string
     */
    public static function getRoleTag(int $role = null): string
    {
        if (is_null($role)) {
            $role = self::current()->group_id;
        }
        return self::$rolesTags[$role] ?? '';
    }

    public static function getSalaryInfo(array $params = []): Collection
    {
        return collect(Api::instance()->getSalaryInfo(self::getToken(), $params));
    }
}
