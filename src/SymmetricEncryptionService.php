<?php


namespace guardiansdk;

class SymmetricEncryptionService
{

    /***
     * Symmetric encryption method
     * @param string $data
     * @param string $key
     * @param string $cypher
     * @return string
     */
    public static function Encrypt(string $data, string $key, $cypher = 'aes-256-cbc'): string
    {
        $ivSize  = openssl_cipher_iv_length($cypher);
        $ivData  = openssl_random_pseudo_bytes($ivSize);
        $encrypted = openssl_encrypt($data,
            $cypher,
            $key,
            OPENSSL_RAW_DATA,
            $ivData);
        return base64_encode($ivData  . $encrypted);
    }

    /***
     * Symmetric decryption method
     * @param string $data
     * @param string $key
     * @param string $cypher
     * @return string
     */
    public static function Decrypt(string $data, string $key, $cypher = 'aes-256-cbc'): string
    {
        $ivSize  = openssl_cipher_iv_length($cypher);
        $data = base64_decode($data);
        $ivData   = substr($data, 0, $ivSize);
        $encData = substr($data, $ivSize);
        return openssl_decrypt($encData,
            $cypher,
            $key,
            OPENSSL_RAW_DATA,
            $ivData);
    }
}