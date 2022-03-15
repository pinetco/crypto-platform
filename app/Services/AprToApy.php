<?php

namespace App\Services;

use App\Traits\Makeable;

class AprToApy
{
    use Makeable;

    protected $apr;

    // frequency in months
    protected $frequency = 365;

    public function __construct($apr)
    {
        $this->apr = $apr;
    }

    public function get()
    {
        $apy = pow((1 + (($this->apr / 100) / $this->frequency)), $this->frequency) - 1;

        return round($apy * 100, 1);
    }
}
