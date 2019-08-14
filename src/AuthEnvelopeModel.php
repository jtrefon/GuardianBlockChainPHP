<?php


namespace guardiansdk;

class AuthEnvelopeModel
{
    private $address;
    private $key;

    /**
     * @return mixed
     */
    public function getAddress():string
    {
        return $this->address;
    }

    /**
     * @param  mixed $address
     * @return AuthEnvelopeModel
     */
    public function setAddress($address):AuthEnvelopeModel
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey():string
    {
        return $this->key;
    }

    /**
     * @param  mixed $key
     * @return AuthEnvelopeModel
     */
    public function setKey($key):AuthEnvelopeModel
    {
        $this->key = $key;
        return $this;
    }
}
