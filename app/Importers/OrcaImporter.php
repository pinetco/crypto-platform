<?php

namespace App\Importers;

use App\Models\Farm;
use Http;

class OrcaImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://api.orca.so/allPools');

        $farm = Farm::firstOrCreate([
            'name' => 'Orca',
            'url' => 'https://www.orca.so/pools',
        ]);

        foreach ($response->collect() as $record) {
            if (empty($record['poolId'])) {
                continue;
            }

            list($tokenOneName, $tokenTwoName) = explode('/', str_replace('[aquafarm]', '', $record['poolId']));

            $farm->importTokens($tokenOneName, $tokenTwoName, [
                'apy' => round($record['apy']['day'], 5),
                'liquidity' => round($record['volume']['month'], 5),
            ]);
        }

        $this->setPopularTokens();
    }
}
