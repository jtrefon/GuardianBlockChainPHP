<?php

declare(strict_types=1);

namespace guardiansdk;

class HistoryModel
{
    public $amount;
    public $dateTime;
    public $from;
    public $to;
    public $id;

    public function __construct(
        float $amount = null,
        string $dateTime = null,
        string $from = null,
        string $to = null,
        string $id = null
    ) {
        $this->amount = $amount;
        $this->dateTime = $dateTime;
        $this->from = $from;
        $this->to = $to;
        $this->id = $id;
    }
}
