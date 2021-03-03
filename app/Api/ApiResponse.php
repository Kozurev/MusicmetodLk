<?php


namespace App\Api;


use Illuminate\Support\Collection;

class ApiResponse
{
    const STATUS_OK = 200;

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

    public function hasErrors(): bool
    {
        return $this->status !== self::STATUS_OK || $this->data()->get('status', true) === false;
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