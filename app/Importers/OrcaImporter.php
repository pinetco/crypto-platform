<?php

namespace App\Importers;

use App\Models\Protocol;
use Http;

class OrcaImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://api.orca.so/allPools');

        $protocol = Protocol::firstOrCreate([
            'name' => 'Orca',
            'url' => 'https://www.orca.so/pools',
        ]);

        foreach ($response->collect() as $record) {
            if (empty($record['poolId'])) {
                continue;
            }

            list($tokenOneName, $tokenTwoName) = explode('/', str_replace('[aquafarm]', '', $record['poolId']));

            $protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
                'apy' => round($record['apy']['day'], 5),
                'tvl' => round($record['volume']['month'], 5),
            ]);
        }

        $this->setPopularTokens();
    }
}
