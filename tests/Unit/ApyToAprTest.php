<?php

namespace Tests\Unit;

use App\Services\ApyToApr;
use Tests\TestCase;

class ApyToAprTest extends TestCase
{
    /** @test */
    public function apy_to_apr_calculation_is_correct()
    {
        $apy = 14246.1;

        $apr = ApyToApr::make($apy)->get();

        $this->assertSame(500.0, $apr);
    }
}
