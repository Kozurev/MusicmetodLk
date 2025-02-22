<?php

declare(strict_types=1);

namespace App\Mappers\P2P;

use App\Collections\P2P\ReceiversCollection;
use App\DTO\P2P\ReceiverDataDTO;
use App\DTO\P2P\ReceiverPaymentDataDTO;
use App\DTO\P2P\ReceiverTeacherDTO;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
final class ReceiverDataMapper
{
    public function mapReceiversDataCollection(array $response): ReceiversCollection
    {
        $instance = $this;
        return new ReceiversCollection(...array_map(
            static fn(\stdClass $receiverData): ReceiverDataDTO  => $instance->mapReceiverData($receiverData),
            $response,
        ));
    }

    public function mapReceiverData(\stdClass $receiverData): ReceiverDataDTO
    {
        return new ReceiverDataDTO(
            teacherDTO: $this->mapTeacherDTO($receiverData->teacher ?? null),
            paymentDataDTO: $this->mapReceiverPaymentDataDTO($receiverData->payment_data ?? null),
        );
    }

    public function mapTeacherDTO(?\stdClass $teacher): ReceiverTeacherDTO
    {
        return new ReceiverTeacherDTO(
            userId: (int)($teacher->userId ?? 0),
            fio: (string)($teacher->fio ?? 'Undefined teacher'),
        );
    }

    public function mapReceiverPaymentDataDTO(?\stdClass $receiverPaymentDataDTO): ReceiverPaymentDataDTO
    {
        return new ReceiverPaymentDataDTO(
            receiverId: (int)($receiverPaymentDataDTO?->receiver_id ?? 0),
            cardNumber: null !== $receiverPaymentDataDTO?->card_number
                ? (string)($receiverPaymentDataDTO->card_number)
                : null,
            phoneNUmber: null !== $receiverPaymentDataDTO?->phone_number
                ? (string)($receiverPaymentDataDTO->phone_number)
                : null,
            comment: null !== $receiverPaymentDataDTO?->comment
                ? (string)($receiverPaymentDataDTO->comment)
                : null,
        );
    }
}
