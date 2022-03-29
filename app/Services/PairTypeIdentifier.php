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

    public function __construct(Token $tokenOne, Token $tokenTwo = null)
    {
        $this->tokenOne = $tokenOne->load('token_type');
        $this->tokenOneName = $tokenOne->name;
        $this->tokenOneType = $tokenOne->token_type->identifier;

        if ($tokenTwo) {
            $this->tokenTwo = $tokenTwo->load('token_type');
            $this->tokenTwoName = $tokenTwo->name;
            $this->tokenTwoType = $tokenTwo->token_type->identifier;
        }
    }

    public function get()
    {
        $tokenOneName = $this->tokenOneName;
        $tokenTwoName = $this->tokenTwoName;

        $tokenOneType = $this->tokenOneType;
        $tokenTwoType = $this->tokenTwoType;

        // single sided token logic
        if (is_null($this->tokenTwo)) {
            if ($this->isSol($this->tokenOne)) {
                return PairType::SINGLE_SIDED_SOL;
            }

            if ($this->isBtcOrEth()) {
                return PairType::SINGLE_SIDED_BTC_ETH;
            }

            if ($tokenOneType === TokenType::STABLE) {
                return PairType::SINGLE_SIDED_STABLE;
            }

            if ($this->isOtherToken($this->tokenOne)) {
                return PairType::SINGLE_SIDED_OTHER;
            }
        }

        if ($tokenOneType === TokenType::STABLE && $tokenTwoType === TokenType::STABLE) {
            return PairType::STABLE_TO_STABLE;
        }

        if ($this->isOtherToken($this->tokenOne) && $this->isOtherToken($this->tokenTwo)) {
            return PairType::OTHER_TO_OTHER;
        }

        if ($this->isSol($this->tokenOne)
            && $this->isSol($this->tokenTwo)
            && !(ctype_upper($tokenOneName) && ctype_upper($tokenTwoName))
            && !$this->isAnyTokensOfType(TokenType::OTHER)
        ) {
            return PairType::SOL_TO_SOL;
        }

        if ($this->isAnyTokenName('BTC')
            && $this->isAnyTokenName('ETH')
        ) {
            return PairType::BTC_ETH_TO_BTC_ETH;
        }

        if (($this->isSol($this->tokenOne) || $this->isSol($this->tokenTwo))
            && $this->isBtcOrEth()
        ) {
            return PairType::SOL_TO_BTC_ETH;
        }

        if ($this->isAnyTokensOfType(TokenType::STABLE)
            && ($this->isOtherToken($this->tokenOne) || $this->isOtherToken($this->tokenTwo))
        ) {
            return PairType::STABLE_TO_OTHER;
        }

        if (($this->isSol($this->tokenOne) || $this->isSol($this->tokenTwo))
            && $this->isAnyTokensOfType(TokenType::STABLE)
        ) {
            return PairType::SOL_TO_STABLE;
        }

        if (($this->isSol($this->tokenOne) || $this->isSol($this->tokenTwo))
            && ($this->isOtherToken($this->tokenOne) || $this->isOtherToken($this->tokenTwo))
        ) {
            return PairType::SOL_TO_OTHER;
        }

        if ($this->isAnyTokensOfType(TokenType::STABLE)
            && $this->isBtcOrEth()
        ) {
            return PairType::BTC_ETH_TO_STABLE;
        }

        if ($this->isBtcOrEth()
            && ($this->isOtherToken($this->tokenOne) || $this->isOtherToken($this->tokenTwo))
        ) {
            return PairType::BTC_ETH_TO_OTHER;
        }

        return PairType::SINGLE_SIDED_OTHER; // TODO: for time being
    }

    protected function isBtcOrEth()
    {
        return $this->isAnyTokenName('BTC')
            || $this->isAnyTokenName('ETH');
    }

    protected function isAnyTokensOfType($type)
    {
        return $this->tokenOneType === $type
            || $this->tokenTwoType === $type;
    }

    protected function isOtherToken(Token $token)
    {
        return $token->token_type->identifier !== TokenType::STABLE
            && !Str::contains($token->name, ['BTC', 'ETH'])
            && !$this->isSol($token);
    }

    protected function isAnyTokenName($name)
    {
        return $this->tokenOneName === $name
            || $this->tokenTwoName === $name;
    }

    protected function isAnyTokenNameEndsWith($name)
    {
        return Str::endsWith($this->tokenOneName, $name)
            || Str::endsWith($this->tokenTwoName, $name);
    }

    protected function isSol(Token $token)
    {
        return Str::endsWith($token->name, 'SOL')
            && $token->token_type->identifier === TokenType::ORIGINAL
            && !Str::contains($token->name, ['1SOL', 'METASOL', 'BABYFLOKISOL', 'ISOL', 'GMSOL', 'PSOL']);
    }
}
