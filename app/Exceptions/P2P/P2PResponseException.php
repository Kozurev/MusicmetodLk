<?php

namespace App\Exceptions\P2P;

/**
 * @author Marketplace Team <trade-services-dev@b2b-center.ru>
 */
class P2PResponseException extends \Exception
{
    public function __construct(
        private string $errorHash,
        private string $errorMessage,
    ) {
        parent::__construct($this->errorHash . PHP_EOL . $this->errorMessage, 0);
    }

    public function getErrorHash(): string
    {
        return $this->errorHash;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
