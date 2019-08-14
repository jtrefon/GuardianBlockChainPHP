<?php

namespace guardiansdk;

/***
 * Class AuthCreateResponseModel
 * @package guardiansdk
 */
class AuthCreateResponseModel
{
    private $status;
    private $message;
    private $address;

    /**
     * @return mixed
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return AuthCreateResponseModel
     */
    public function setStatus($status): AuthCreateResponseModel
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return AuthCreateResponseModel
     */
    public function setMessage($message): AuthCreateResponseModel
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress():string
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return AuthCreateResponseModel
     */
    public function setAddress($address): AuthCreateResponseModel
    {
        $this->address = $address;
        return $this;
    }
}
