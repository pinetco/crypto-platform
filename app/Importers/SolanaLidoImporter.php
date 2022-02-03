<?php

namespace App\Importers;

use App\Models\Farm;
use Http;

class SolanaLidoImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://solana.lido.fi/api/defi');

        $farm = Farm::firstOrCreate([
            'name' => 'Solana Lido',
            'url' => 'https://solana.lido.fi/defi',
        ]);

        foreach ($response->collect() as $record) {
            $tokenOneName = $record['PoolLeftToken'];
            $tokenTwoName = $record['PoolRightToken'];

            $farm->importTokens($tokenOneName, $tokenTwoName, [
                'apy' => round($record['totalApy'], 5),
                'liquidity' => round($record['totalValueLockedInUsd'], 5),
            ]);
        }

        $this->setPopularTokens();
    }
}
