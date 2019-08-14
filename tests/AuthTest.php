<?php
declare(strict_types=1);

use guardiansdk\AuthEnvelopeModel;
use guardiansdk\AuthService;
use guardiansdk\AuthTransportService;
use guardiansdk\KeyPayloadModel;
use PHPUnit\Framework\TestCase;
use tests\ConfigHelper;

class AuthTest extends TestCase
{
    protected $auth;
    protected $config;

    protected function setUp()
    {
        $this->auth = new AuthService();
        $this->config = ConfigHelper::getConfig();
    }


    public function testGetAddress(): void
    {
        $username = "TestUserName";
        $password = "TestPassword123!";
        $expected = hash("sha256", $username.$password, false);
        $this->assertEquals($expected, $this->auth->getAddress($username, $password));
    }

    public function testGetEncryptionPassword(): void
    {
        $username = "TestUserName";
        $password = "TestPassword123!";
        $expected = hash("sha512", $username.$password, false);
        $this->assertEquals($expected, $this->auth->getEncryptionKey($username, $password));
    }

    public function testPayloadEncryptDecrypt(): void
    {
        $encrypted = $this->auth->encryptPayload($this->getMockedPayload(), "Password123!");
        $decrypted = $this->auth->decryptPayload($encrypted, "Password123!");
        $this->assertEquals($decrypted, $this->getMockedPayload());
    }


    public function testPersistWallet():void
    {
        if ($this->config["mock"]) {
            return;
        }
        $user = "TestUser";
        $password = "TestPassword!";
        $transport = new AuthTransportService();
        $envelope = new AuthEnvelopeModel();
        $envelope
            ->setKey($this->auth->encryptPayload($this->getMockedPayload(), $password))
            ->setAddress($this->auth->getAddress($user, $password));
        $response = $transport->persistWallet($envelope);
        $this->assertEquals($envelope->getAddress(), $response->getAddress());
    }

    public function testKeyRestore(): void
    {
        if ($this->config["mock"]) {
            return;
        }
        $envelope = new AuthEnvelopeModel();
        $envelope->setKey("keyaddress")->setAddress("address");
        $transport = new AuthTransportService();
        $transport->persistWallet($envelope);
        $response = $transport->getKey($envelope->getAddress());
        $this->assertEquals($envelope->getKey(), $response->getPayload());
    }


    protected function getMockedPayload(): KeyPayloadModel
    {
        $payload = new KeyPayloadModel();
        $payload->Address = "Address";
        $payload->Private = "Private";
        $payload->Public = "Public";
        return $payload;
    }
}
