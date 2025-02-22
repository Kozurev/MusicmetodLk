<?php

namespace App\Api;

use Illuminate\Support\Collection;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
class P2PApiResponse
{
    private bool $status;
    private ?string $error_hash;
    private ?string $error_message;
    private Collection $data;

    /**
     * ApiResponse constructor.
     * @param \stdClass $responseData
     */
    public function __construct(\stdClass $responseData)
    {
        $responseData = json_decode($responseData->content);
        $this->status = $responseData->status;
        $this->error_hash = $responseData->error_hash ?? null;
        $this->error_message = $responseData->error_message ?? null;
        $this->data = new Collection((array)($responseData->data ?? []));
    }

    public function hasError(): bool
    {
        return $this->status === false || $this->error_message !== null || $this->error_hash !== null;
    }

    public function getErrorMessage(): ?string
    {
        return $this->error_message;
    }

    public function getErrorHash(): ?string
    {
        return $this->error_hash;
    }

    public function getData(): Collection
    {
        return $this->data;
    }
}
