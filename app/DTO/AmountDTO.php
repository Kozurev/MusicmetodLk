<?php

namespace App\DTO;

class AmountDTO
{

    /**
     * Количество символов после запятой
     */
    public const PRECISION = 2;

    /**
     * @param int $amount
     * @param int $precision
     */
    private function __construct(
        private readonly int $amount,
        private readonly int $precision = self::PRECISION,
    ) {}

    /**
     * @param float|int $decimal
     * @param int $precision
     * @return int
     */
    public static function decimalToAmount(
        float|int $decimal,
        int $precision = self::PRECISION,
    ): int {
        return (int)round(
            num: ($decimal * (10 ** $precision)),
            precision: 0,
        );
    }

    /**
     * @param int $amount
     * @param int $precision
     * @return float|int
     */
    public static function amountToDecimal(
        int $amount,
        int $precision = self::PRECISION,
    ): float|int {
        return $amount / (10 ** $precision);
    }

    /**
     * @param float|int $decimal
     * @param int $precision
     * @return static
     */
    public static function getFromDecimal(
        float|int $decimal,
        int $precision = self::PRECISION,
    ): static {
        return new static(
            self::decimalToAmount($decimal, $precision),
        );
    }

    /**
     * @param int $amount
     * @param int $precision
     * @return static
     */
    public static function getFromAmount(
        int $amount,
        int $precision = self::PRECISION,
    ): static {
        return new static($amount, $precision);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return float|int
     */
    public function getDecimalAmount(): float|int
    {
        return self::amountToDecimal($this->amount, $this->precision);
    }
}
