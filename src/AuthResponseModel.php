<?php


namespace guardiansdk;

class AuthResponseModel
{
    private $status;
    private $payload;

    /**
     * @return mixed
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param  mixed $status
     * @return AuthResponseModel
     */
    public function setStatus($status): AuthResponseModel
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param  mixed $payload
     * @return AuthResponseModel
     */
    public function setPayload($payload): AuthResponseModel
    {
        $this->payload = $payload;
        return $this;
    }
}
