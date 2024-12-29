<?php

declare(strict_types=1);

namespace App\DTO\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class ReceiverTeacherDTO
{
    public function __construct(
        private int $userId,
        private string $fio,
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFio(): string
    {
        return $this->fio;
    }
}
