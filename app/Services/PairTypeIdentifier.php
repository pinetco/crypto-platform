<?php

namespace App\Services;

use App\Models\TokenType;
use Str;
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

    protected $tokenOneName;
    protected $tokenTwoName;

    protected $tokenOneType;
    protected $tokenTwoType;

    public function __construct(Token $tokenOne, Token $tokenTwo)
    {
        $this->tokenOne = $tokenOne->load('token_type');
        $this->tokenTwo = $tokenTwo->load('token_type');

        $this->tokenOneName = strtolower($tokenOne->name);
        $this->tokenTwoName = strtolower($tokenTwo->name);

        $this->tokenOneType = $tokenOne->token_type->identifier;
        $this->tokenTwoType = $tokenTwo->token_type->identifier;
    }

    public function get()
    {
        $tokenOneName = strtolower($this->tokenOne->name);
        $tokenTwoName = strtolower($this->tokenTwo->name);

        $tokenOneType = $this->tokenOne->token_type->identifier;
        $tokenTwoType = $this->tokenTwo->token_type->identifier;

        if ($tokenOneType === TokenType::STABLE && $tokenTwoType === TokenType::STABLE) {
            return PairType::STABLE_TO_STABLE;
        }

        if ($tokenOneType === TokenType::OTHER && $tokenTwoType === TokenType::OTHER) {
            return PairType::OTHER_TO_OTHER;
        }

        if ($this->isAnyTokensOfType(TokenType::STABLE)
            && $this->isAnyTokensOfType(TokenType::OTHER)
        ) {
            return PairType::STABLE_TO_OTHER;
        }

        if ($this->isAnyTokenName('sol')
            && $this->isAnyTokensOfType(TokenType::STABLE)
        ) {
            return PairType::SOL_TO_STABLE;
        }

        if ($this->isAnyTokenName('sol')
            && $this->isAnyTokensOfType(TokenType::OTHER)
        ) {
            return PairType::SOL_TO_OTHER;
        }

        if (Str::contains($tokenOneName, 'sol')
            && Str::contains($tokenTwoName, 'sol')
        ) {
            return PairType::SOL_TO_SOL;
        }

        if ($this->isAnyTokenName('sol')
            && $this->isBtcOrEth()
        ) {
            return PairType::SOL_TO_BTC_ETH;
        }

        if ($this->isAnyTokensOfType(TokenType::STABLE)
            && $this->isBtcOrEth()
        ) {
            return PairType::BTC_ETH_TO_STABLE;
        }

        if ($this->isAnyTokensOfType(TokenType::OTHER)
            && $this->isBtcOrEth()
        ) {
            return PairType::BTC_ETH_TO_OTHER;
        }

        if ($this->isAnyTokenName('btc')
            && $this->isAnyTokenName('eth')
        ) {
            return PairType::BTC_ETH_TO_BTC_ETH;
        }

        // SINGLE_SIDED_STABLE
        // SINGLE_SIDED_OTHER
        // SINGLE_SIDED_SOL
        // SINGLE_SIDED_BTC_ETH

        return PairType::SINGLE_SIDED_STABLE; // TODO: for time being
    }

    protected function isBtcOrEth()
    {
        return $this->isAnyTokenName('btc')
            || $this->isAnyTokenName('eth');
    }

    protected function isAnyTokensOfType($type)
    {
        return $this->tokenOneType === $type
            || $this->tokenTwoType === $type;
    }

    protected function isAnyTokenName($name)
    {
        return Str::contains($this->tokenOneName, $name)
            || Str::contains($this->tokenTwoName, $name);
    }
}
