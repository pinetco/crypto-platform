<?php

namespace App\Services;

use Arr;
use Str;
use App\Traits\Makeable;
use App\Models\TokenType;

class TokenTypeIdentifier
{
    use Makeable;

    protected $tokenName;

    public function __construct($tokenName)
    {
        $this->tokenName = $tokenName;
    }

    public function get()
    {
        $tokenName = $this->tokenName;

        if (Str::contains($tokenName, ['USD', 'DAI', 'MIM', 'FRAX', 'UST', 'MAI', 'CASH'])) {
            return TokenType::STABLE;
        }

        if (ctype_upper($tokenName)) {
            return TokenType::ORIGINAL;
        }

        if (Str::startsWith($tokenName, ['aa', 'ab', 'ac', 'ae', 'af', 'ag', 'ah', 'ap', 'at', 'so', 'sol', 'we', 'wb', 'wib', 'wt', 'wh'])) {
            return TokenType::BRIDGED;
        }

        if (Str::startsWith($tokenName, ['a', 'm', 'e', 'c', 'p', 'prt', 'ren', 's', 'scn', 'st', 'w', 'wst', 'x', 'y'])) {
            return TokenType::LIQUID_STACKED;
        }

        return TokenType::OTHER;
    }
}
