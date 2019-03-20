<?php

namespace guardiansdk;

/**
 * Class TransactionResponseModel
 * @package guardiansdk
 */
class TransactionResponseModel
{
    public $transactionId;

    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }
}