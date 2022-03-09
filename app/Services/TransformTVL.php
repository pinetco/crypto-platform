<?php

namespace App\Services;

use App\Traits\Makeable;

class TransformTVL
{
    use Makeable;

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function get()
    {
        $value = $this->value;

        if ($value < 100) { // Round to 2 decimals
            return round($value, 2);
        }

        if ($value >= 100 && $value < 20000) { // Round to nearest decimal
            return round($value);
        }

        if ($value >= 20000 && $value < 100000000) { // Round to nearest thousand
            return round($value, -3);
        }

        if ($value >= 100000000 && $value < 100000000000) { // Round to nearest million
            return round($value, -6);
        }

        if ($value >= 100000000000) { // Round to nearest billion
            return round($value, -9);
        }
    }
}
