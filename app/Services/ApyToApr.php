<?php

namespace App\Services;

use App\Traits\Makeable;

class ApyToApr
{
    use Makeable;

    protected $apy;

    // frequency in months
    protected $frequency = 365;

    public function __construct($apy)
    {
        $this->apy = $apy;
    }

    public function get()
    {
        $periodicRate = pow((1 + $this->apy / 100), (1 / $this->frequency)) - 1;

        return round($periodicRate * $this->frequency * 100, 1);
    }
}
