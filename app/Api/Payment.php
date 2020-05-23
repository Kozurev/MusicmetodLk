<?php

namespace App\Api;


class Payment
{
    const PAYMENT_TYPE_INCOME = 1;
    const PAYMENT_TYPE_DEBIT = 2;
    const PAYMENT_TYPE_TEACHER = 3;
    const PAYMENT_TYPE_CASHBACK = 15;
    const PAYMENT_TYPE_BONUS_ADD = 16;
    const PAYMENT_TYPE_BONUS_PAY = 17;

    protected static $types = [
        self::PAYMENT_TYPE_INCOME,
        self::PAYMENT_TYPE_INCOME,
        self::PAYMENT_TYPE_DEBIT,
        self::PAYMENT_TYPE_TEACHER,
        self::PAYMENT_TYPE_CASHBACK,
        self::PAYMENT_TYPE_BONUS_ADD,
        self::PAYMENT_TYPE_BONUS_PAY
    ];

    public static function getList() : array
    {
        return self::$types;
    }

    public static function getLangList() : array
    {
        $output = [];
        foreach (self::getList() as $type) {
            $output[$type] = __('api.payment-type-' . $type);
        }
        return $output;
    }

    public static function getName(int $type) : string
    {
        return self::getLangList()[$type] ?? '';
    }

}
