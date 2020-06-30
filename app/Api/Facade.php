<?php

namespace App\Api;

use Illuminate\Support\Facades\Log;

class Facade
{
    const PARAM_ACTION = 'action';
    const PARAM_TOKEN = 'token';
    const PARAM_LOGIN = 'login';
    const PARAM_PASSWORD = 'password';
    const PARAM_DATE_START = 'date_start';
    const PARAM_RATE_ID = 'tarif_id';
    const PARAM_AMOUNT = 'amount';
    const PARAM_DESCRIPTION = 'description';
    const PARAM_SUCCESS_URL = 'successUrl';
    const PARAM_ERROR_URL = 'errorUrl';

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    const ACTION_AUTH = 'do_auth';
    const ACTION_GET_USER = 'get_user';
    const ACTION_GET_NEAREST_LESSONS = 'get_nearest_lessons';
    const ACTION_GET_CLIENT_PAYMENTS = 'get_client_payments';
    const ACTION_GET_CLIENT_REPORTS = 'get_client_reports';
    const ACTION_GET_CLIENT_SCHEDULE = 'get_client_schedule';
    const ACTION_GET_CLIENT_RATES = 'get_list';
    const ACTION_GET_RATE_BY_ID = 'get_rate_by_id';
    const ACTION_BUY_RATE = 'buy_tarif';
    const ACTION_MAKE_DEPOSIT = 'registerOrder';

    /**
     * @var Facade
     */
    private static $_instance;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string[]
     */
    private static $action2url = [
        self::ACTION_AUTH                   => '/user/index.php',
        self::ACTION_GET_USER               => '/user/index.php',
        self::ACTION_GET_NEAREST_LESSONS    => '/schedule/index.php',
        self::ACTION_GET_CLIENT_PAYMENTS    => '/payment/index.php',
        self::ACTION_GET_CLIENT_REPORTS     => '/schedule/index.php',
        self::ACTION_GET_CLIENT_SCHEDULE    => '/schedule/index.php',
        self::ACTION_GET_CLIENT_RATES       => '/tarif/index.php',
        self::ACTION_GET_RATE_BY_ID         => '/tarif/index.php',
        self::ACTION_BUY_RATE               => '/tarif/index.php',
        self::ACTION_MAKE_DEPOSIT           => '/payment/index.php',
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
    public static function instance() : Facade
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
    public function makeUrl(string $action) : string
    {
        return $this->apiUrl . (self::$action2url[$action] ?? '');
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @return \stdClass|null
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

        $result = json_decode(curl_exec($ch));
        if (empty($result) || !is_null($result->error ?? null)) {
            Log::error('Error request for url: ' . $url . ' ' . ($result->message ?? ''), $params);
        }
        curl_close($ch);
        return $result;
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
     * @return \stdClass|null
     */
    public function getPayments(string $token, array $params = [])
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_CLIENT_PAYMENTS;
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_CLIENT_PAYMENTS), $params);
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
     * @param array $params
     * @return \stdClass|null
     */
    public function getLessons(string $token, array $params = [])
    {
        $params[self::PARAM_TOKEN] = $token;
        $params[self::PARAM_ACTION] = self::ACTION_GET_CLIENT_SCHEDULE;
        return $this->makeRequest($this->makeUrl(self::ACTION_GET_CLIENT_SCHEDULE), $params);
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

}
