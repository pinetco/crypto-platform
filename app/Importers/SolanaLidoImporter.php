<?php

namespace App\Importers;

use App\Models\Protocol;
use Http;

class SolanaLidoImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://solana.lido.fi/api/defi');

        $protocol = Protocol::firstOrCreate([
            'name' => 'Solana Lido',
            'url' => 'https://solana.lido.fi/defi',
        ]);

        foreach ($response->collect() as $record) {
            $tokenOneName = $record['PoolLeftToken'];
            $tokenTwoName = $record['PoolRightToken'];

            $protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
                'apy' => round($record['totalApy'], 5),
                'tvl' => round($record['totalValueLockedInUsd'], 5),
            ]);
        }

        $this->setPopularTokens();
    }
}
