<?php

declare (strict_types = 1);
namespace guardiansdk;

class CryptoService
{
    protected $keySize = 1024;
    protected $private;
    protected $public;

    public function GenerateNewSet(): void
    {
        $ssl = openssl_pkey_new(array('private_key_bits' => $this->keySize));
        openssl_pkey_export($ssl, $this->private);
        $pubkey = openssl_pkey_get_details($ssl);
        $this->public = $pubkey["key"];
    }

    public function GetPrivateKey(): string
    {
        return $this->private;
    }

    public function GetPublicKey(): string
    {
        return $this->public;
    }

    public function Sign(string $privkey, $payload): string
    { 
        openssl_sign($payload, $signature, $privkey);
        return $signature;
    }

    public function Verify(string $pubkey, string $signature, string $payload): bool {
        $res = openssl_verify($payload, $signature, $pubkey);
        return $res === 1;
    }
}

