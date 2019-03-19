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
            'wallet/'.$wallet,
            [
            'debug' => $this->debug,
            'body' => null,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            ]
        );

        return $this->parseBalance($response);
    }

    private function parseBalance(ResponseInterface $response): BalanceModel
    {
        $responseObject = json_decode(
            $response->getBody()->getContents()
        );
        $balance = new BalanceModel();
        $balance->balance = $responseObject->balance;

        return $balance;
    }

    public function getWalletAddress(string $publicKey): WalletModel
    {
        $response = $this->client->post(
            'wallet',
            [
            'debug' => $this->debug,
            'body' => \GuzzleHttp\json_encode(new WalletModel($publicKey)),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            ]
        );

        return $this->parseWallet($response);
    }

    private function parseWallet(ResponseInterface $response): WalletModel
    {
        $responseObject = \GuzzleHttp\json_decode(
            $response->getBody()->getContents()
        );
        $wallet = new WalletModel();
        $wallet->publicKey = $responseObject->publicKey;
        $wallet->walletId = $responseObject->walletId;

        return $wallet;
    }

    public function getHistory(string $wallet): array
    {
        $response = $this->client->get(
            'transaction/'.$wallet,
            [
            'debug' => $this->debug,
            'body' => null,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            ]
        );

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}
