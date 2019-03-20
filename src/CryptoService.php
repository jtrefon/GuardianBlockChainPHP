<?php

/**
 * Cryptographic service.
 */
declare(strict_types=1);

namespace guardiansdk;

/**
 * Class CryptoService.
 */
class CryptoService
{
    protected $keySize = 1024;
    protected $private;
    protected $public;

    /**
     * Generates new set of RSA key pair.
     */
    public function generateNewSet(): void
    {
        $ssl = openssl_pkey_new(array('private_key_bits' => $this->keySize));
        openssl_pkey_export($ssl, $this->private);
        $pubkey = openssl_pkey_get_details($ssl);
        $this->public = $pubkey['key'];
    }

    /**
     * Returns Private key string.
     *
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->private;
    }

    /**
     * Returns public key string.
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->public;
    }

    /**
     * Provides RSA signature for provided payload.
     *
     * @param string  $privkey
     * @param $payload
     *
     * @return string
     */
    public function sign(string $privkey, $payload): string
    {
        openssl_sign($payload, $signature, $privkey);

        return $signature;
    }

    /**
     * Verifies payload based on provided signatue and key.
     *
     * @param string $pubkey
     * @param string $signature
     * @param string $payload
     *
     * @return bool
     */
    public function verify(
        string $pubkey,
        string $signature,
        string $payload
    ): bool {
        $res = openssl_verify($payload, $signature, $pubkey);

        return 1 === $res;
    }
}
