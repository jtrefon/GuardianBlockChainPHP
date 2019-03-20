<?php

namespace guardiansdk;

class TransactionModel
{
    public $from;
    public $to;
    public $amount;

    /**
     * TransactionModel constructor.
     * This is model saturator
     *
     * @param string $from
     * @param string $to
     * @param double $amount
     */
    public function __construct($from, $to, $amount)
    {
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
    }
}
