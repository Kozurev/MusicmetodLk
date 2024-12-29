<?php

namespace App\DTO\P2P;

use Illuminate\Support\Collection;

/**
 * @property ReceiverDataDTO[] $items
 * @method ReceiverDataDTO[] all()
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final class ReceiversCollection extends Collection
{
    public function __construct(ReceiverDataDTO ...$receiverDataDTO)
    {
        parent::__construct($receiverDataDTO);
    }
}
