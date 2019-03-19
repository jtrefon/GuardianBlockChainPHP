<?php

declare(strict_types=1);

namespace guardiansdk;

class WalletModel
{
    public $publicKey;
    public $walletId;

    public function __construct(string $public = null, string $wallet = null)
    {
        $this->walletId = $wallet;
        $this->publicKey = $public;
    }
}
