<?php

namespace App\Models;

use App\Services\PairTypeIdentifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairType extends Model
{
    use HasFactory;

    public $timestamps = false;

    const SINGLE_SIDED_STABLE = 'single_sided_stable',
        SINGLE_SIDED_OTHER = 'single_sided_other',
        STABLE_TO_STABLE = 'stable_to_stable',
        STABLE_TO_OTHER = 'stable_to_other',
        SINGLE_SIDED_SOL = 'single_sided_sol',
        SOL_TO_STABLE = 'sol_to_stable',
        SOL_TO_SOL = 'sol_to_sol',
        SOL_TO_BTC_ETH = 'sol_to_btc_eth',
        SOL_TO_OTHER = 'sol_to_other',
        OTHER_TO_OTHER = 'other_to_other',
        SINGLE_SIDED_BTC_ETH = 'single_sided_btc_eth',
        BTC_ETH_TO_OTHER = 'btc_eth_to_other',
        BTC_ETH_TO_STABLE = 'btc_eth_to_stable',
        BTC_ETH_TO_BTC_ETH = 'btc_eth_to_btc_eth',
        UNDEFINED = 'undefined';

    public static function identify(Token $tokenOne, Token $tokenTwo)
    {
        return self::where('identifier', PairTypeIdentifier::make($tokenOne, $tokenTwo)->get())->first();
    }
}
