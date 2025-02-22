<?php

namespace App\Mappers\P2P;

use App\DTO\P2P\RemotePaymentDTO;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class RemotePaymentMapper
{
    public function __construct(
        private PaymentMapper $paymentMapper,
        private TransactionMapper $transactionMapper,
    ) {}

    public function mapRemotePaymentDTO(array $remotePayment): RemotePaymentDTO
    {
        return new RemotePaymentDTO(
            paymentDTO: $this->paymentMapper->mapPayment($remotePayment['payment'] ?? new \stdClass()),
            transactionDTO: $this->transactionMapper->mapTransactionDTO($remotePayment['transaction'] ?? new \stdClass()),
        );
    }
}
