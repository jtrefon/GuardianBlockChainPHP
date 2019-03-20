<?php

namespace guardiansdk;

class EnvelopeModel
{
    public $PublicKey;
    public $Signature;
    public $Transaction;

    /**
     * EnvelopeModel constructor.
     * Model Saturator
     *
     * @param string $PublicKey
     * @param string $Signature
     * @param string $Transaction
     */
    public function __construct(string $PublicKey, string $Signature, string $Transaction)
    {
        $this->PublicKey = $PublicKey;
        $this->Signature = $Signature;
        $this->Transaction = $Transaction;
    }
}
