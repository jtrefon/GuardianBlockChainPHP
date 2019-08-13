<?php
declare(strict_types=1);

namespace guardiansdk;

/**
 * This is Authentication Service
 */

class AuthService
{
    /***
     * Makes sha256 hash out of concatenated username and password to be used as key address
     * @param string $username
     * @param string $password
     * @return string
     */
    public function GetAddress(string $username, string $password): string
    {
        return hash('sha256', $username . $password, false);
    }

    /***
     * Makes sha512 hash out of concatenated username and password to be used as key encryption password
     * @param string $username
     * @param string $password
     * @return string
     */
    public function GetEncryptionKey(string $username, string $password): string
    {
        return hash('sha512', $username . $password, false);
    }

    /***
     * @param KeyPayloadModel $payloadModel
     * @param string $password
     * @return string
     */
    public function EncryptPayload(KeyPayloadModel $payloadModel, string $password): string
    {
        return SymmetricEncryptionService::Encrypt
        (
            json_encode($payloadModel),
            $password
        );
    }

    /***
     * @param string $payload
     * @param string $password
     * @return KeyPayloadModel
     */
    public function DecryptPayload(string $payload, string $password): KeyPayloadModel
    {
        return json_decode(SymmetricEncryptionService::Decrypt($payload, $password));
    }
}