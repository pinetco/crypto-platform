<?php

namespace App\Models;

use App\Services\TransformTVL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function importTokenPairs($tokenOneName, $tokenTwoName, $properties = [])
    {
        $fromToken = Token::getToken($tokenOneName);
        $toToken = Token::getToken($tokenTwoName);

        $properties['tvl'] = TransformTVL::make($properties['tvl'])->get();

        $tokenCombination = TokenCombination::firstOrCreate([
            'protocol_id' => $this->id,
            'pair_type_id' => PairType::identify($fromToken, $toToken)->id,
            'from_token_id' => $fromToken->id,
            'to_token_id' => $toToken->id,
        ], $properties);
    }
}
