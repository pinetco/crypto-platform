<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function importTokens($tokenOneName, $tokenTwoName, $properties = [])
    {
        $fromToken = Token::firstOrCreate([
            'name' => $tokenOneName
        ]);

        $toToken = Token::firstOrCreate([
            'name' => $tokenTwoName
        ]);

        $tokenCombination = TokenCombination::firstOrCreate([
            'farm_id' => $this->id,
            'from_token_id' => $fromToken->id,
            'to_token_id' => $toToken->id,
        ], $properties);
    }
}
