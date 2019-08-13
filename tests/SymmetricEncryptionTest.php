<?php
declare(strict_types=1);

use guardiansdk\SymmetricEncryptionService;
use PHPUnit\Framework\TestCase;

class SymmetricEncryptionTest extends TestCase
{
    protected $enc;
    protected $message = "This is test message to be encrypted and decrypted";
    protected $key = "This is encryption key phrase!";

    protected function setUp()
    {
        $this->enc = new SymmetricEncryptionService();
    }

    public function testEncryptionDecryption(): void
    {
        $encrypted = $this->enc->encrypt($this->message, $this->key);
        $decrypted = $this->enc->decrypt($encrypted, $this->key);
        $this->assertEquals(
            $this->message,
            $decrypted
        );
    }



}