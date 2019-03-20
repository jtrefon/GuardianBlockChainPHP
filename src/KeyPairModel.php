<?php

namespace guardiansdk;

class KeyPairModel
{
    public $privateKey;
    public $publicKey;

    public function __construct(string $privateKey, string $publicKey)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }
}
