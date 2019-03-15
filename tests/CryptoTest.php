<?php
declare(strict_types=1);

use guardiansdk\CryptoService;
use PHPUnit\Framework\TestCase;

class CryptoTest extends TestCase
{


public function testNewWallet(): void {
    $crypto = new CryptoService();
    $crypto->GenerateNewSet();
    $this->assertNotEmpty($crypto->GetPrivateKey());
    $this->assertNotEmpty($crypto->GetPublicKey());
    }
}