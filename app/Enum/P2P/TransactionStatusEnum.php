<?php

namespace App\Enum\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
enum TransactionStatusEnum: int
{
    /**
     * Транзакция создана и находится в обработке
     */
    case PENDING = 1;

    /**
     * Подтверждена получателем
     */
    case APPROVED_BY_RECEIVER = 2;

    /**
     * Подтверждена менеджером
     */
    case APPROVED_BY_MANAGER = 3;

    /**
     * Отменена получателем
     */
    case REJECTED_BY_RECEIVER = 4;

    /**
     * Отменена менеджером
     */
    case REJECTED_BY_MANAGER = 5;
}
