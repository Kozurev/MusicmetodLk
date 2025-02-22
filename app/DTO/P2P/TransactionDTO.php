<?php

namespace App\DTO\P2P;

use App\DTO\AmountDTO;
use App\Enum\P2P\TransactionStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final readonly class TransactionDTO
{
    public function __construct(
        private int $id,
        private TransactionStatusEnum $status,
        private AmountDTO $amount,
        private int $receiverId,
        private Carbon $createdAt,
        private Carbon $updatedAt,
        private Collection $extraData,
        private ?string $receiptLink = null,
        private ?int $receiptFileId = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): TransactionStatusEnum
    {
        return $this->status;
    }

    public function getAmount(): AmountDTO
    {
        return $this->amount;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function getExtraData(): Collection
    {
        return $this->extraData;
    }

    public function getReceiptLink(): ?string
    {
        return $this->receiptLink;
    }

    public function getReceiptFileId(): ?int
    {
        return $this->receiptFileId;
    }
}
