<?php

namespace App\Mappers\P2P;

use App\DTO\AmountDTO;
use App\DTO\P2P\TransactionDTO;
use App\Enum\P2P\TransactionStatusEnum;
use Carbon\Carbon;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
class TransactionMapper
{
    public function mapTransactionDTO(\stdClass $transaction): TransactionDTO
    {
        return new TransactionDTO(
            id: (int)$transaction->id ?? 0,
            status: TransactionStatusEnum::tryFrom($transaction->status ?? TransactionStatusEnum::PENDING->value),
            amount: AmountDTO::getFromDecimal((float)$transaction->amount ?? 0),
            receiverId: (int)$transaction->receiver_id ?? 0,
            createdAt: Carbon::parse($transaction->created_at ?? Carbon::now()),
            updatedAt: Carbon::parse($transaction->updated_at ?? Carbon::now()),
            extraData: collect($transaction->extra_data ?? []),
            receiptLink: $transaction->receiptLink ?? null,
            receiptFileId: $transaction->receiptFileId ?? null,
        );
    }
}
