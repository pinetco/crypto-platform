<?php

namespace App\Importers;

use App\Models\Token;
use App\Models\TokenCombination;
use App\Traits\Makeable;
use Http;

class RaydiumImporter
{
    use Makeable;

    public function handle()
    {
        $response = Http::get('https://api.raydium.io/pairs');

        foreach ($response->collect() as $record) {
            list($tokenOneName, $tokenTwoName) = explode('-', $record['name']);

            if ($tokenOneName == 'unknown' || $tokenTwoName == 'unknown') {
                continue;
            }

            $fromToken = Token::firstOrCreate([
                'name' => $tokenOneName
            ]);

            $toToken = Token::firstOrCreate([
                'name' => $tokenTwoName
            ]);

            $tokenCombination = TokenCombination::firstOrCreate([
                'from_token_id' => $fromToken->id,
                'to_token_id' => $toToken->id,
            ], [
                'apy' => $record['apy'],
            ]);
        }

        $this->setPopularTokens();
    }

    protected function setPopularTokens()
    {
        Token::has('combinations', '>', 3)
            ->inRandomOrder()
            ->take(7)
            ->get()
            ->each
            ->update(['is_popular' => true]);
    }
}
