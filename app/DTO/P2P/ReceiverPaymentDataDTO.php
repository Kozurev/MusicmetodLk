<?php

declare(strict_types=1);

namespace App\DTO\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class ReceiverPaymentDataDTO
{
    public function __construct(
        private int $receiverId,
        private ?string $cardNumber = null,
        private ?string $phoneNUmber = null,
        private ?string $comment = null,
    ) {}

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNUmber;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
