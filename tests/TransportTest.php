<?php
declare(strict_types=1);

use guardiansdk\TransportService;
use PHPUnit\Framework\TestCase;

class TransportTest extends TestCase
{

public function testBalance(): void {
    $transport = new TransportService();
    $balance = $transport->getBalance("10ca96ee75eef3e5aa242f64608cb4a67fed5395d925dec0679b89e4c010649c");
    $this->assertEquals(0,$balance->balance);
}

public function testNewWallet(): void {
    $transport = new TransportService();
    $response = $transport->getWalletAddress("asdasdsadsadsd");
    $this->assertEquals("0f125463d0af398eb9deaa424d1c091e30885fed2ea0256d7b5884c19339b616",$response->walletId);
    $this->assertNotEmpty($response->publicKey);
}
    public function testHistory(): void {
        $transport = new TransportService();
        $response = $transport->getHistory("0f125463d0af398eb9deaa424d1c091e30885fed2ea0256d7b5884c19339b616");
        $this->assertIsArray($response);
    }

}