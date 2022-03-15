<?php

namespace Tests\Unit;

use App\Services\AprToApy;
use Tests\TestCase;

class AprToApyTest extends TestCase
{
    /** @test */
    public function apr_to_apy_calculation_is_correct()
    {
        $apr = 500;

        $apy = AprToApy::make($apr)->get();

        $this->assertSame(14246.1, $apy);
    }
}
