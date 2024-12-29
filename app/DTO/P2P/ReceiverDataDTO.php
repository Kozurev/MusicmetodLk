<?php

declare(strict_types=1);

namespace App\DTO\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class ReceiverDataDTO
{
    public function __construct(
        private ReceiverTeacherDTO $teacherDTO,
        private ReceiverPaymentDataDTO $paymentDataDTO
    ) {}

    public function getTeacherDTO(): ReceiverTeacherDTO
    {
        return $this->teacherDTO;
    }

    public function getPaymentDataDTO(): ReceiverPaymentDataDTO
    {
        return $this->paymentDataDTO;
    }
}
