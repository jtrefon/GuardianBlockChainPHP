<?php

namespace guardiansdk;

class TransactionService
{
    protected $transport;
    protected $crypto;

    public function __construct()
    {
        $this->transport = new TransportService();
        $this->crypto = new CryptoService();
    }

    /**
     * Executes transaction on blockchain
     *
     * @param  string $from
     * @param  string $to
     * @param  float  $amount
     * @param  string $publicKey
     * @param  string $privateKey
     * @return TransactionResponseModel
     */
    public function transact(
        string $from,
        string $to,
        float $amount,
        string $publicKey,
        string $privateKey
    ): TransactionResponseModel {
        $transaction = base64_encode(json_encode(new TransactionModel($from, $to, (string)$amount)));
        return $this->transport->sendTransaction(
            new EnvelopeModel(
                $publicKey,
                base64_encode($this->crypto->sign($privateKey, $transaction)),
                $transaction
            )
        );
    }
}
