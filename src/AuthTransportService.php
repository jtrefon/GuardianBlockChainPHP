<?php


namespace guardiansdk;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AuthTransportService extends TransportService
{
    /**
     * @param string $address
     * @return AuthResponseModel
     */
    public function getKey(string $address): AuthResponseModel
    {
        $response = $this->client->get(
            'auth/'.$address,
            $this->getHeaders()
        );
        $serializer = $this->getSerializer();
        return $serializer->deserialize(
            $response->getBody()->getContents(),
            AuthResponseModel::class,
            'json'
        );
    }

    /***
     * @param AuthEnvelopeModel $envelope
     * @return AuthCreateResponseModel
     */
    public function persistWallet(AuthEnvelopeModel $envelope): AuthCreateResponseModel
    {
        $serializer = $this->getSerializer();
        $response = $this->client->post(
            'auth',
            $this->getHeaders($serializer->serialize($envelope, 'json'))
        );
        return $serializer->deserialize(
            $response->getBody()->getContents(),
            AuthCreateResponseModel::class,
            'json'
        );
    }

    /***
     * @return Serializer
     */
    private function getSerializer(): Serializer
    {
        return new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }
}
