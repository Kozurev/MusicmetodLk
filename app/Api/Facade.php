<?php

namespace App\Api;

use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;
use mysql_xdevapi\Collection;

class Facade
{
    const PARAM_ACTION = 'action';
    const PARAM_TOKEN = 'token';
    const PARAM_ID = 'id';
    const PARAM_LOGIN = 'login';
    const PARAM_PASSWORD = 'password';
    const PARAM_DATE_START = 'date_start';
    const PARAM_DATE_END = 'date_end';
    const PARAM_RATE_ID = 'tarif_id';
    const PARAM_AMOUNT = 'amount';
    const PARAM_DESCRIPTION = 'description';
    const PARAM_SUCCESS_URL = 'successUrl';
    const PARAM_ERROR_URL = 'errorUrl';
    const PARAM_TEACHER_ID = 'teacherId';
    const PARAM_DATE = 'date';
    const PARAM_LESSON_DURATION = 'lessonDuration';
    const PARAM_LESSON_ID = 'lessonId';
    const PARAM_LESSON_ATTENDANCE = 'attendance';
    const PARAM_LESSON_ATTENDANCE_CLIENTS = 'attendance_clients';
    const PARAM_DATE_FROM = 'date_from';
    const PARAM_DATE_TO = 'date_to';
    const PARAM_TIME_FROM = 'time_from';
    const PARAM_TIME_TO = 'time_to';
    const PARAM_CONFIG_TAG = 'tag';
    const PARAM_WITHOUT_PAGINATE = 'without_paginate';
    const PARAM_AREA_ID = 'area_id';

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    const ACTION_AUTH = 'do_auth';
    const ACTION_GET_USER = 'get_user';
    const ACTION_GET_NEAREST_LESSONS = 'get_nearest_lessons';
    const ACTION_GET_PAYMENTS = 'get_payments';
    const ACTION_GET_CLIENT_REPORTS = 'get_client_reports';
    const ACTION_GET_CLIENT_RATES = 'get_list';
    const ACTION_GET_RATE_BY_ID = 'get_rate_by_id';
    const ACTION_GET_SCHEDULE_AREAS = 'getAreasList';
    const ACTION_GET_SCHEDULE_SHORT = 'get_schedule_short';
    const ACTION_GET_SCHEDULE_FULL = 'get_schedule_full';
    const ACTION_GET_TEACHER_SCHEDULE_STATISTIC = 'getReportsStatistic';
    const ACTION_BUY_RATE = 'buy_tarif';
    const ACTION_MAKE_DEPOSIT = 'registerOrder';
    const ACTION_GET_TEACHERS = 'getClientTeachers';
    const ACTION_GET_CLIENTS = 'getTeacherClients';
    const ACTION_GET_TEACHER_SCHEDULE = 'getTeacherSchedule';
    const ACTION_GET_TEACHER_NEAREST_TIME = 'getTeacherNearestTime';
    const ACTION_LESSON_SAVE = 'saveLesson';
    const ACTION_LESSON_ABSENT = 'markAbsent';
    const ACTION_LESSON_REPORT = 'makeReport';
    const ACTION_LESSON_CHANGE_TIME = 'lessonChangeTime';
    const ACTION_ABSENT_PERIOD_LIST = 'getAbsentPeriods';
    const ACTION_ABSENT_PERIOD_SAVE = 'saveAbsentPeriod';
    const ACTION_ABSENT_PERIOD_DELETE = 'deleteScheduleAbsent';
    const ACTION_CONFIG_GET = 'config_get';

    /**
     * @var Facade|null
     */
    private static ?Facade $_instance = null;

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * @var string[]
     */
    private static $action2url = [
        self::ACTION_AUTH                   => '/user/index.php',
        self::ACTION_GET_USER               => '/user/index.php',
        self::ACTION_GET_NEAREST_LESSONS    => '/schedule/index.php',
        self::ACTION_GET_PAYMENTS           => '/payment/index.php',
        self::ACTION_GET_CLIENT_REPORTS     => '/schedule/index.php',
        self::ACTION_GET_SCHEDULE_SHORT     => '/schedule/index.php',
        self::ACTION_GET_SCHEDULE_FULL      => '/schedule/index.php',
        self::ACTION_GET_TEACHER_SCHEDULE_STATISTIC => '/schedule/index.php',
        self::ACTION_GET_CLIENT_RATES       => '/tarif/index.php',
        self::ACTION_GET_RATE_BY_ID         => '/tarif/index.php',
        self::ACTION_BUY_RATE               => '/tarif/index.php',
        self::ACTION_MAKE_DEPOSIT           => '/payment/index.php',
        self::ACTION_GET_CLIENTS            => '/user/index.php',
        self::ACTION_GET_TEACHERS           => '/user/index.php',
        self::ACTION_GET_TEACHER_SCHEDULE   => '/schedule/index.php',
        self::ACTION_GET_TEACHER_NEAREST_TIME=>'/schedule/index.php',
        self::ACTION_LESSON_SAVE            => '/schedule/index.php',
        self::ACTION_LESSON_ABSENT          => '/schedule/index.php',
        self::ACTION_LESSON_REPORT          => '/schedule/index.php',
        self::ACTION_LESSON_CHANGE_TIME     => '/schedule/index.php',
        self::ACTION_ABSENT_PERIOD_LIST     => '/schedule/index.php',
        self::ACTION_ABSENT_PERIOD_SAVE     => '/schedule/index.php',
        self::ACTION_ABSENT_PERIOD_DELETE   => '/schedule/index.php',
        self::ACTION_CONFIG_GET             => '/config/index.php',
        self::ACTION_GET_SCHEDULE_AREAS     => '/schedule/index.php'
    ];

    /**
     * Facade constructor.
     * @param string $apiUrl
     */
    private function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return Facade
     */
    public static function instance(): self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self(env('SERVER_API_URL', ''));
        }
        return self::$_instance;
    }

    /**
     * @param string $action
     * @return string
     */
    public function makeUrl(string $action): string
    {
        return $this->apiUrl . (self::$action2url[$action] ?? '');
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @return \stdClass|array|null
     */
    public function makeRequest(string $url, array $params, string $method = self::METHOD_GET)
    {
        $queryParams = http_build_query($params);

        if ($method == self::METHOD_GET) {
            $url .= '?' . $queryParams;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($method == self::METHOD_POST) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryParams);
        }
        //Log::info('API action "'.($params[self::PARAM_ACTION] ?? '').'": ' . $url);
        $result = json_decode(curl_exec($ch));
        if (is_null($result) || !is_null($result->error ?? null)) {
            Log::error('Error request for url: ' . $url . ' ' . ($result->message ?? ''), $params);
        }
        curl_close($ch);
        return $result;
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @return ApiResponse
     */
    public function getResponse(string $url, array $params, string $method = self::METHOD_GET): ApiResponse
    {
        $request = Curl::to($url)
            ->withHeaders(['Content-Type: application/json', 'Accept: application/json'])
            ->withData($params)
            ->asJsonRequest()
            ->returnResponseObject()
            ->withTimeout(30);
        if ($method == self::METHOD_GET) {
            $response = $request->get();
        } else {
            $response = $request->post();
        }
        return new ApiResponse($response);
    }

    /**
     * @param $response
     * @return string
     */
    public static function getResponseErrorMessage($response): string
    {
        if ($response->message ?? '') {
            return strval($response->message);
        } else {
            return self::getErrorMessage($response->error ?? null);
        }
    }

    /**
     * @param int|null $error
     * @return string
     */
    public static function getErrorMessage(int $error = null): string
    {
        $langTag = !is_null($error)
            ?   'errors.' . $error
            :   'error-undefined';
        return __('api.' . $langTag);
    }

    /**
     * @param string $login
     * @param string $password
     * @return \stdClass|null
     */
    public function auth(string $login, string $password)
    {
        return $this->makeRequest($this->makeUrl(self::ACTION_AUTH), [
            self::PARAM_ACTION => self::ACTION_AUTH,
            self::PARAM_LOGIN => $login,
            self::PARAM_PASSWORD => $password
        ], self::METHOD_POST);
    }

    /**
     * @param string $token
     * @return \stdClass|null
     */
    public function getUser(string $token)
    {
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_USER), [
            self::PARAM_ACTION => self::ACTION_GET_USER,
            self::PARAM_TOKEN => $token
        ], self::METHOD_GET);
    }

    /**
     * @param string $token
     * @param string|null $dateStart
     * @return \stdClass|null
     */
    public function getNearestLessons(string $token, string $dateStart = null)
    {
        $params = [
            self::PARAM_ACTION => self::ACTION_GET_NEAREST_LESSONS,
            self::PARAM_TOKEN => $token
        ];
        if (!is_null($dateStart)) {
            $params[self::PARAM_DATE_START] = $dateStart;
        }
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_NEAREST_LESSONS), $params);
    }


    /**
     * @param string $token
     * @param array $params
     * @return array
     */
    public function getPayments(string $token, array $params = []): array
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_PAYMENTS;
        return (array)$this->makeRequest($this->makeUrl(self::ACTION_GET_PAYMENTS), $params);
    }

    /**
     * @param string $token
     * @param array $params
     * @return \stdClass|null
     */
    public function getReports(string $token, array $params = [])
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_CLIENT_REPORTS;
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_CLIENT_REPORTS), $params);
    }

    /**
     * @param string $token
     * @return array
     */
    public function getAreas(string $token): array
    {
        $params = [
            self::PARAM_TOKEN => $token,
            self::PARAM_ACTION => self::ACTION_GET_SCHEDULE_AREAS
        ];
        return (array)$this->makeRequest($this->makeUrl(self::ACTION_GET_SCHEDULE_AREAS), $params, self::METHOD_GET);
    }

    /**
     * @param string $token
     * @param array $params
     * @return ApiResponse
     */
    public function getScheduleShort(string $token, array $params = []): ApiResponse
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_SCHEDULE_SHORT;
        return $this->getResponse($this->makeUrl(self::ACTION_GET_SCHEDULE_SHORT), $params);
    }

    /**
     * @param string $token
     * @param int $areaId
     * @param string|null $date
     * @return ApiResponse
     */
    public function getScheduleFull(string $token, int $areaId, ?string $date = null): ApiResponse
    {
        $params = [
            self::PARAM_TOKEN => $token,
            self::PARAM_ACTION => self::ACTION_GET_SCHEDULE_FULL,
            self::PARAM_AREA_ID => $areaId
        ];
        if (!is_null($date)) {
            $params[self::PARAM_DATE] = $date;
        }
        return $this->getResponse($this->makeUrl(self::ACTION_GET_SCHEDULE_FULL), $params);
    }

    /**
     * @param string $token
     * @param array $params
     * @return array|null
     */
    public function getTeacherScheduleStatistic(string $token, array $params = []) : ?array
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_TEACHER_SCHEDULE_STATISTIC;
        return (array)$this->makeRequest($this->makeUrl(self::ACTION_GET_TEACHER_SCHEDULE_STATISTIC), $params);
    }

    /**
     * @param string $token
     * @param array $params
     * @return \stdClass|null
     */
    public function getRates(string $token, array $params = [])
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_CLIENT_RATES;
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_CLIENT_RATES), $params);
    }

    /**
     * @param string $token
     * @param int $rateId
     * @return \stdClass|null
     */
    public function getRateById(string $token, int $rateId)
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_RATE_BY_ID;
        $params[self::PARAM_RATE_ID] = $rateId;
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_RATE_BY_ID), $params);
    }

    /**
     * @param string $token
     * @param int $rateId
     * @return \stdClass|null
     */
    public function buyRate(string $token, int $rateId)
    {
        $params = [
            self::PARAM_TOKEN => $token,
            self::PARAM_ACTION => self::ACTION_BUY_RATE,
            self::PARAM_RATE_ID => $rateId
        ];
        return $this->makeRequest($this->makeUrl(self::ACTION_BUY_RATE), $params);
    }

    /**
     * @param string $token
     * @param int $amount
     * @param string|null $description
     * @param string|null $successUrl
     * @param string|null $errorUrl
     * @return \stdClass|null
     */
    public function makeDeposit(string $token, int $amount, string $description = null, string $successUrl = null, string $errorUrl = null)
    {
        $params = [
            self::PARAM_ACTION => self::ACTION_MAKE_DEPOSIT,
            self::PARAM_TOKEN => $token,
            self::PARAM_AMOUNT => $amount
        ];
        if (!is_null($description)) {
            $params[self::PARAM_DESCRIPTION] = $description;
        }
        if (!is_null($successUrl)) {
            $params[self::PARAM_SUCCESS_URL] = $successUrl;
        }
        if (!is_null($errorUrl)) {
            $params[self::PARAM_ERROR_URL] = $errorUrl;
        }

        return $this->makeRequest($this->makeUrl(self::ACTION_MAKE_DEPOSIT), $params);
    }

    /**
     * @param string $token
     * @return \stdClass|null
     */
    public function getTeachers(string $token)
    {
        $params = [
            self::PARAM_ACTION => self::ACTION_GET_TEACHERS,
            self::PARAM_TOKEN => $token
        ];

        return $this->makeRequest($this->makeUrl(self::ACTION_GET_TEACHERS), $params);
    }

    /**
     * @param string $token
     * @return ApiResponse
     */
    public function getClients(string $token): ApiResponse
    {
        $params = [
            self::PARAM_ACTION => self::ACTION_GET_CLIENTS,
            self::PARAM_TOKEN => $token
        ];

        return $this->getResponse($this->makeUrl(self::ACTION_GET_CLIENTS), $params);
    }

    /**
     * @param string $token
     * @param int $teacherId
     * @return \stdClass|null
     */
    public function getTeacherSchedule(string $token, int $teacherId)
    {
        $params = [
            self::PARAM_ACTION => self::ACTION_GET_TEACHER_SCHEDULE,
            self::PARAM_TOKEN => $token,
            self::PARAM_TEACHER_ID => $teacherId
        ];
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_TEACHER_SCHEDULE), $params);
    }

    /**
     * @param string $token
     * @param int $teacherId
     * @param string $date
     * @param int $lessonDurationMinutes
     * @return \stdClass|null
     */
    public function getTeacherNearestTime(string $token, int $teacherId, string $date, int $lessonDurationMinutes)
    {
        $params = [
            self::PARAM_ACTION => self::ACTION_GET_TEACHER_NEAREST_TIME,
            self::PARAM_TOKEN => $token,
            self::PARAM_TEACHER_ID => $teacherId,
            self::PARAM_DATE => $date,
            self::PARAM_LESSON_DURATION => $lessonDurationMinutes
        ];

        return $this->makeRequest($this->makeUrl(self::ACTION_GET_TEACHER_NEAREST_TIME), $params);
    }

    /**
     * @param string $token
     * @param array $lessonData
     * @return \stdClass|null
     */
    public function lessonSave(string $token, array $lessonData)
    {
        $lessonData[self::PARAM_TOKEN] = $token;
        $lessonData[self::PARAM_ACTION] = self::ACTION_LESSON_SAVE;

        return $this->makeRequest($this->makeUrl(self::ACTION_LESSON_SAVE), $lessonData, self::METHOD_POST);
    }

    /**
     * Отмена занятия
     *
     * @param string $token
     * @param int $lessonId
     * @param string $date
     * @return \stdClass|null
     */
    public function lessonAbsent(string $token, int $lessonId, string $date)
    {
        $params = [
            self::PARAM_TOKEN => $token,
            self::PARAM_ACTION => self::ACTION_LESSON_ABSENT,
            self::PARAM_LESSON_ID => $lessonId,
            self::PARAM_DATE => $date
        ];
        return $this->makeRequest($this->makeUrl(self::ACTION_LESSON_ABSENT), $params, self::METHOD_POST);
    }

    /**
     * @param string $token
     * @param int $lessonId
     * @param string $date
     * @param string $timeFrom
     * @param string $timeTo
     * @return ApiResponse
     */
    public function lessonTimeModify(string $token, int $lessonId, string $date, string $timeFrom, string $timeTo): ApiResponse
    {
        return $this->getResponse($this->makeUrl(self::ACTION_LESSON_CHANGE_TIME), [
            self::PARAM_ACTION => self::ACTION_LESSON_CHANGE_TIME,
            self::PARAM_TOKEN => $token,
            self::PARAM_LESSON_ID => $lessonId,
            self::PARAM_DATE => $date,
            self::PARAM_TIME_FROM => $timeFrom,
            self::PARAM_TIME_TO => $timeTo
        ], self::METHOD_POST);
    }

    /**
     * @param string $token
     * @param array $params
     * @return \stdClass|null
     */
    public function getAbsentPeriods(string $token, array $params = [])
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_ABSENT_PERIOD_LIST;
        return $this->makeRequest($this->makeUrl(self::ACTION_ABSENT_PERIOD_LIST), $params);
    }

    /**
     * @param string $token
     * @param array $params
     * @return \stdClass|null
     */
    public function saveAbsentPeriod(string $token, array $params = [])
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_ABSENT_PERIOD_SAVE;
        return $this->makeRequest($this->makeUrl(self::ACTION_ABSENT_PERIOD_SAVE), $params, self::METHOD_POST);
    }

    /**
     * @param string $token
     * @param int $id
     * @return \stdClass|null
     */
    public function deleteAbsentPeriod(string $token, int $id)
    {
        $params = [
            self::PARAM_TOKEN => $token,
            self::PARAM_ACTION => self::ACTION_ABSENT_PERIOD_DELETE,
            self::PARAM_ID => $id
        ];
        return $this->makeRequest($this->makeUrl(self::ACTION_ABSENT_PERIOD_DELETE), $params, self::METHOD_POST);
    }

    /**
     * @param string $token
     * @param string $configTag
     * @return \stdClass|null
     */
    public function getConfig(string $token, string $configTag)
    {
        $params = [
            self::PARAM_TOKEN => $token,
            self::PARAM_ACTION => self::ACTION_CONFIG_GET,
            self::PARAM_CONFIG_TAG => $configTag
        ];
        return $this->makeRequest($this->makeUrl(self::ACTION_CONFIG_GET), $params, self::METHOD_GET);
    }

    /**
     * @param string $token
     * @param array $params
     * @return \stdClass|null
     */
    public function lessonReport(string $token, array $params = []): ?\stdClass
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_LESSON_REPORT;
        return $this->makeRequest($this->makeUrl(self::ACTION_LESSON_REPORT), $params, self::METHOD_POST);
    }
}
