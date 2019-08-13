<?php
declare(strict_types=1);

use guardiansdk\AuthService;
use guardiansdk\KeyPayloadModel;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    protected $auth;

    protected function setUp()
    {
        $this->auth = new AuthService();
    }


    public function testGetAddress(): void
    {
        $username = "TestUserName";
        $password = "TestPassword123!";
        $expected = hash("sha256", $username.$password, false);
        $this->assertEquals($expected, $this->auth->getAddress($username, $password));
    }

    public function testGetEncriptionPassowrd(): void
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

    protected function getMockedPayload(): KeyPayloadModel
    {
        $payload = new KeyPayloadModel();
        $payload->Address = "Address";
        $payload->Private = "Private";
        $payload->Public = "Public";
        return $payload;
    }

}