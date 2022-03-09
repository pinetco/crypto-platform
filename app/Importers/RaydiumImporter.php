<?php

namespace App\Importers;

use Http;
use App\Models\Protocol;

class RaydiumImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://api.raydium.io/pairs');

        $protocol = Protocol::firstOrCreate([
            'name' => 'Raydium',
            'icon_path' => 'icons/raydium.svg',
            'url' => 'https://raydium.io/farms',
        ]);

        foreach ($response->collect() as $record) {
            list($tokenOneName, $tokenTwoName) = explode('-', $record['name']);

            if ($tokenOneName == 'unknown' || $tokenTwoName == 'unknown') {
                continue;
            }

            $protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
                'apy' => round($record['apy'], 5),
                'tvl' => round($record['liquidity'], 5),
            ]);
        }
    }
}
