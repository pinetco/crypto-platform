<?php

namespace App\Services;

use App\Traits\Makeable;

class AprToApy
{
    use Makeable;

    protected $apr;

    // frequency in months
    protected $frequency = 12;

    public function __construct($apr)
    {
        $this->apr = $apr;
    }

    public function get()
    {
        $periodicRate = pow((1 + $this->apr / 100), (1 / $this->frequency)) - 1;

        return round($periodicRate * $this->frequency * 100, 5);
    }
}
