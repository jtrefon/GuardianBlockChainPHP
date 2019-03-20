<?php

declare(strict_types=1);

namespace guardiansdk;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TransportService.
 */
class TransportService
{
    protected $client;
    protected $debug = false;
    protected $server = 'http://prime.guardianbc.com/';

    /**
     * TransportService constructor.
     * sets up url and timeout default values.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => $this->server,
                'timeout' => 3.0,
            ]
        );
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
        $response = $this->client->get(
            'wallet/' . $wallet,
            $this->getHeaders()
        );

        return $this->parseBalance($response);
    }

    /**
     * Parses response into Balance model
     *
     * @param  ResponseInterface $response
     * @return BalanceModel
     */
    protected function parseBalance(ResponseInterface $response): BalanceModel
    {
        $responseObject = json_decode(
            $response->getBody()->getContents()
        );
        $balance = new BalanceModel();
        $balance->balance = $responseObject->balance;

        return $balance;
    }

    /**
     * Requests wallet address from Blockchain providing public key
     *
     * @param  string $publicKey
     * @return WalletModel
     */
    public function getWalletAddress(string $publicKey): WalletModel
    {
        $response = $this->client->post(
            'wallet',
            $this->getHeaders(\GuzzleHttp\json_encode(new WalletModel($publicKey)))
        );

        return $this->parseWallet($response);
    }

    /**
     * Parses http response into Wallet model
     *
     * @param  ResponseInterface $response
     * @return WalletModel
     */
    protected function parseWallet(ResponseInterface $response): WalletModel
    {
        $responseObject = \GuzzleHttp\json_decode(
            $response->getBody()->getContents()
        );
        $wallet = new WalletModel();
        $wallet->publicKey = $responseObject->publicKey;
        $wallet->walletId = $responseObject->walletId;

        return $wallet;
    }

    /**
     * Retrieves History for given wallet
     *
     * @param  string $wallet
     * @return array
     */
    public function getHistory(string $wallet): array
    {
        $response = $this->client->get(
            'transaction/' . $wallet,
            $this->getHeaders()
        );

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Sets headers for API call
     *
     * @param  string|null $body
     * @return array
     */
    protected function getHeaders(string $body = null): array
    {
        return [
            'debug' => $this->debug,
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];
    }

    /**
     * Executes transaction on Blockchain
     *
     * @param  EnvelopeModel $envelope
     * @return TransactionResponseModel
     */
    public function sendTransaction(EnvelopeModel $envelope): TransactionResponseModel
    {
        $response = $this->client->post(
            'transaction',
            $this->getHeaders(\GuzzleHttp\json_encode($envelope))
        );
        return $this->parseTransaction($response);
    }

    /**
     * Parses Transaction response into saturated model
     *
     * @param  ResponseInterface $response
     * @return TransactionResponseModel
     */
    protected function parseTransaction(ResponseInterface $response): TransactionResponseModel
    {
        $responseObject = \GuzzleHttp\json_decode(
            $response->getBody()->getContents()
        );
        return new TransactionResponseModel($responseObject->transactionId);
    }
}
