<?php

namespace App\Services;

use App\Models\PairType;
use App\Models\Token;
use App\Traits\Makeable;

class PairTypeIdentifier
{
    use Makeable;

    /** @var Token */
    protected $tokenOne;

    /** @var Token */
    protected $tokenTwo;

    public function __construct(Token $tokenOne, Token $tokenTwo)
    {
        $this->tokenOne = $tokenOne->load('token_type');
        $this->tokenTwo = $tokenTwo->load('token_type');
    }

    public function get()
    {
        $tokenOneName = strtolower($this->tokenOne->name);
        $tokenTwoName = strtolower($this->tokenTwo->name);

        $tokenOneType = $this->tokenOne->token_type->identifier;
        $tokenTwoType = $this->tokenTwo->token_type->identifier;

        if ($tokenOneType === 'stable' && $tokenTwoType === 'stable') {
            return PairType::STABLE_TO_STABLE;
        }

        if (($tokenOneType === 'stable' || $tokenTwoType === 'stable')
            && ($tokenOneType === 'other' || $tokenTwoType === 'other')
        ) {
            return PairType::STABLE_TO_OTHER;
        }

        if (($tokenOneName === 'sol' || $tokenTwoName === 'sol')
            && ($tokenOneType === 'stable' || $tokenTwoType === 'stable')
        ) {
            return PairType::SOL_TO_STABLE;
        }

        if ($tokenOneName === 'sol' && $tokenTwoName === 'sol') {
            return PairType::SOL_TO_SOL;
        }

        return PairType::SINGLE_SIDED_STABLE; // TODO: for time being
    }
}
