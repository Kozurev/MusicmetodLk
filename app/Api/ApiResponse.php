<?php


namespace App\Api;


use Illuminate\Support\Collection;

class ApiResponse
{
    const STATUS_OK = 200;

    const ERROR_CODE_EMPTY = 0;         //Ошибки отсутствуют
    const ERROR_CODE_AUTH = 1;          //Пользователь не авторизован
    const ERROR_CODE_ACCESS = 2;        //Недостаточно прав
    const ERROR_CODE_NOT_FOUND = 3;     //Объект не найден
    const ERROR_CODE_TIME = 4;          //Неподходящее время
    const ERROR_CODE_REQUIRED_PARAM = 5;//Отсутствует обязательный параметр
    const ERROR_CODE_PASSWORD_CONFIRMATION = 6; //Пароли не совпаают
    const ERROR_CODE_PASSWORD_OLD = 7;          //Неверно введен старый пароль
    const ERROR_CODE_CUSTOM = 999;      //Кастомная ошибка

    /**
     * @var int
     */
    protected int $status;

    /**
     * @var Collection
     */
    protected Collection $responseData;

    /**
     * ApiResponse constructor.
     * @param \stdClass $responseData
     */
    public function __construct(\stdClass $responseData)
    {
        $this->status = intval($responseData->status);
        $this->responseData = collect(json_decode($responseData->content));
    }

    /**
     * @return Collection
     */
    public function data(): Collection
    {
        return $this->responseData;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return !$this->hasErrors();
    }

    public function hasErrors(): bool
    {
        return $this->status !== self::STATUS_OK || (bool)$this->data()->get('status', true) === false;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return intval($this->data()->get('error', 0));
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return strval($this->data()->get('message', self::getErrorCodeTranslation($this->getErrorCode())));
    }

    /**
     * @param int $error
     * @return string
     */
    public static function getErrorCodeTranslation(int $error): string
    {
        return __('api.errors.' . $error);
    }
}
