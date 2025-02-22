<?php

namespace App\Mappers\P2P;

use App\DTO\P2P\PaymentDTO;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
class PaymentMapper
{
    public function mapPayment(\stdClass $payment): PaymentDTO
    {
        return new PaymentDTO(
            paymentId: $payment->id ?? 0,
        );
    }
}
