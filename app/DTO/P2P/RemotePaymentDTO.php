<?php

namespace App\DTO\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class RemotePaymentDTO
{
    public function __construct(
        private PaymentDTO $paymentDTO,
        private TransactionDTO $transactionDTO,
    ) {}

    public function getPaymentDTO(): PaymentDTO
    {
        return $this->paymentDTO;
    }

    public function getTransactionDTO(): TransactionDTO
    {
        return $this->transactionDTO;
    }
}
