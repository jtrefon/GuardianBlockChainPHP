<?php
declare(strict_types=1);

use guardiansdk\CryptoService;
use PHPUnit\Framework\TestCase;

class CryptoTest extends TestCase
{
    protected $crypto;

    protected function setUp()
    {
        $this->crypto = new CryptoService();
    }


    public function testNewKeyPair(): void {
        $this->crypto->GenerateNewSet();
        $this->assertNotEmpty($this->crypto->GetPrivateKey());
        $this->assertNotEmpty($this->crypto->GetPublicKey());
    }

    public function testSignature(): void {
        $this->crypto->GenerateNewSet();
        $payload = "This is a simple test";
        $signature = $this->crypto->Sign($this->crypto->GetPrivateKey(), $payload);
        $this->assertNotEmpty($signature);
        $this->assertTrue(
            $this->crypto->Verify($this->crypto->GetPublicKey(),$signature,$payload)
        );
    }
}