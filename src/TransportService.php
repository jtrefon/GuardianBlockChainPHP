<?php
declare(strict_types=1);

namespace guardiansdk;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class TransportService
{
    protected $client;
    protected $debug = false;
    protected $server = "http://prime.guardianbc.com/";

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->server,
            'timeout' => 3.0
        ]);
    }

    public function GetBalance(string $wallet): BalanceModel
    {
        $response = $this->client->get("wallet/" . $wallet, [
            'debug' => $this->debug,
            'body' => null,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
        return $this->parseBalance($response);
    }

    private function parseBalance(ResponseInterface $response): BalanceModel {
        $responseObject = json_decode(
            $response->getBody()->getContents()
        );
        $balance = new BalanceModel();
        $balance->balance = $responseObject->balance;
        return $balance;
    }

    public function GetWalletAddress(string $publicKey) : WalletModel {
        $response = $this->client->post("wallet",[
            'debug' => $this->debug,
            'body' => \GuzzleHttp\json_encode(new WalletModel($publicKey)),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);
        return $this->parseWallet($response);
    }

    private function parseWallet(ResponseInterface $response): WalletModel {
        $responseObject = json_decode(
            $response->getBody()->getContents()
        );
        $wallet = new WalletModel();
        $wallet->publicKey = $responseObject->publicKey;
        $wallet->walletId = $responseObject->walletId;
        return $wallet;
    }

}