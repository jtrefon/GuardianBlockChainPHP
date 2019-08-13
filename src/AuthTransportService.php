<?php


namespace guardiansdk;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AuthTransportService extends TransportService
{
    public function persistWallet(AuthEnvelopeModel $envelope): AuthCreateResponseModel
    {
        $response = $this->client->post(
            'auth',
            $this->getHeaders(\GuzzleHttp\json_encode($envelope))
        );
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return $serializer->deserialize(
            $response->getBody()->getContents(),
            AuthCreateResponseModel::class,
            'json'
        );
    }
}
