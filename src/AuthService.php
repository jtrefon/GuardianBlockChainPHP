<?php
declare(strict_types=1);

namespace guardiansdk;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * This is Authentication Service
 */

class AuthService
{
    protected $keyPayload;
    protected $authenticated = false;
    protected $transport;

    public function __construct()
    {
        $this->transport = new AuthTransportService();
    }

    public function authenticate(string $username, string $password): void
    {
        $encryptedKey = $this->transport->getKey(
            $this->getAddress($username, $password)
        );
        if ($encryptedKey->status === "Error") {
            $this->authenticated = false;
            return;
        }
        $this->keyPayload = $this->decryptPayload(
            $encryptedKey->payload,
            $this->getEncryptionKey($username, $password)
        );
        $this->authenticated = true;
    }


    /***
     * Makes sha256 hash out of concatenated username and password to be used as key address
     *
     * @param  string $username
     * @param  string $password
     * @return string
     */
    public function getAddress(string $username, string $password): string
    {
        return hash('sha256', $username . $password, false);
    }

    /***
     * Makes sha512 hash out of concatenated username and password to be used as key encryption password
     *
     * @param  string $username
     * @param  string $password
     * @return string
     */
    public function getEncryptionKey(string $username, string $password): string
    {
        return hash('sha512', $username . $password, false);
    }

    /***
     * @param  KeyPayloadModel $payloadModel
     * @param  string          $password
     * @return string
     */
    public function encryptPayload(KeyPayloadModel $payloadModel, string $password): string
    {
        return SymmetricEncryptionService::encrypt(
            json_encode($payloadModel),
            $password
        );
    }

    /***
     * @param  string $payload
     * @param  string $password
     * @return KeyPayloadModel
     * @throws ExceptionInterface
     */
    public function decryptPayload(string $payload, string $password): KeyPayloadModel
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return $serializer->deserialize(
            SymmetricEncryptionService::decrypt($payload, $password),
            KeyPayloadModel::class,
            'json'
        );
    }
}
