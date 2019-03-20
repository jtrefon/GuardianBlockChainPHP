<?php

declare(strict_types=1);

namespace guardiansdk;

class GuardianFacade
{
    protected $transport;
    protected $crypto;
    protected $transaction;

    public function __construct()
    {
        $this->transaction = new TransactionService();
        $this->transport = new TransportService();
        $this->crypto = new CryptoService();
    }

    /**
     * RSA Key pair generator
     *
     * @return KeyPairModel
     */
    public function getKeyPair(): KeyPairModel
    {
        $this->crypto->generateNewSet();
        return new KeyPairModel(
            $this->crypto->getPrivateKey(),
            $this->crypto->getPublicKey()
        );
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
    public function sendTransaction(
        string $from,
        string $to,
        float $amount,
        string $publicKey,
        string $privateKey
    ): TransactionResponseModel {
        return $this->transaction->transact($from, $to, $amount, $publicKey, $privateKey);
    }

    /**
     * GetBalance - runs call to blockchain to request current balance for given wallet address.
     *
     * @param string $wallet
     *
     * @return BalanceModel
     */
    public function getBalance(string $wallet): BalanceModel
    {
        return $this->transport->getBalance($wallet);
    }


    /**
     * Requests wallet address from Blockchain providing public key
     *
     * @param  string $publicKey
     * @return WalletModel
     */
    public function getWalletAddress(string $publicKey): WalletModel
    {
        return $this->transport->getWalletAddress($publicKey);
    }

    /**
     * Retrieves History for given wallet
     *
     * @param  string $wallet
     * @return array
     */
    public function getHistory(string $wallet): array
    {
        return $this->transport->getHistory($wallet);
    }
}
