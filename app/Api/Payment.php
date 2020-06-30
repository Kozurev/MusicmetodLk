<?php

namespace App\Api;


class Payment
{
    const TYPE_INCOME = 1;
    const TYPE_DEBIT = 2;
    const TYPE_TEACHER = 3;
    const TYPE_CASHBACK = 15;
    const TYPE_BONUS_ADD = 16;
    const TYPE_BONUS_PAY = 17;

    const STATUS_PENDING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_ERROR = 2;

    /**
     * @var int[]
     */
    protected static $types = [
        self::TYPE_INCOME,
        self::TYPE_INCOME,
        self::TYPE_DEBIT,
        self::TYPE_TEACHER,
        self::TYPE_CASHBACK,
        self::TYPE_BONUS_ADD,
        self::TYPE_BONUS_PAY
    ];

    /**
     * @var int[]
     */
    protected static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_COMPLETE,
        self::STATUS_ERROR
    ];

    /**
     * @return array|int[]
     */
    public static function getTypesList() : array
    {
        return self::$types;
    }

    /**
     * @return array
     */
    public static function getLangTypesList() : array
    {
        $output = [];
        foreach (self::getTypesList() as $type) {
            $output[$type] = self::getTypeName($type);
        }
        return $output;
    }

    /**
     * @param int $type
     * @return string
     */
    public static function getTypeName(int $type) : string
    {
        return __('api.payment-type-' . $type);
    }

    /**
     * @return array|int[]
     */
    public static function getStatusesList() : array
    {
        return self::$statuses;
    }

    /**
     * @return array
     */
    public static function getLangStatusesList() : array
    {
        $output = [];
        foreach (self::getStatusesList() as $status) {
            $output[$status] = self::getStatusName($status);
        }
        return $output;
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getStatusName(int $status) : string
    {
        return __('api.payment-status-' . $status);
    }

    /**
     * @param float $amount
     * @return string
     */
    public static function format(float $amount) : string
    {
        return number_format(($amount /100), 2, '.', ' ');
    }

}
