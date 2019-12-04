<?php

declare(strict_types=1);

namespace guardiansdk;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TransportService
{
    protected $client;
    protected $debug = false;
    protected $server;

    /**
     * TransportService constructor.
     * sets up url and timeout default values.
     */
    public function __construct()
    {
        $config = new ConfigService();
        $this->server = $config->getUrl();
        $this->client = new Client(
            [
                'base_uri' => $this->server,
                'timeout' => 3.0,
            ]
        );
    }

    /***
     * Enables Debugging for testing purposes
     */
    public function enableDebug(): void
    {
        $this->debug = true;
    }

    /**
     * GetBalance - runs call to blockchain
     * to request current balance for given wallet address.
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
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return $serializer->deserialize(
            $response->getBody()->getContents(),
            BalanceModel::class,
            'json'
        );
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
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return $serializer->deserialize(
            $response->getBody()->getContents(),
            WalletModel::class,
            'json'
        );
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

        return \GuzzleHttp\json_decode(
            $response->getBody()->getContents(),
            true
        );
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
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return $serializer->deserialize(
            $response->getBody()->getContents(),
            TransactionResponseModel::class,
            'json'
        );
    }
}
