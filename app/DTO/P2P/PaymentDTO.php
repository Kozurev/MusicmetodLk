<?php

namespace App\DTO\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class PaymentDTO
{
    public function __construct(
        private int $paymentId,
    ) {}

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }
}
