<?php

namespace App\Importers;

use App\Models\Protocol;
use Http;

class RaydiumImporter extends Importer
{
    public function handle()
    {
        if(app()->environment('local')) {
            $data = json_decode(\Storage::disk('local')->get('pairs.json'), true);
        } else {
            $response = Http::get('https://api.raydium.io/pairs');
            $data = $response->collect();
        }

        $protocol = Protocol::firstOrCreate([
            'name' => 'Raydium',
            'icon_path' => 'icons/raydium.svg',
            'url' => 'https://raydium.io/farms',
        ]);

        foreach ($data as $record) {
            list($tokenOneName, $tokenTwoName) = explode('-', $record['name']);

            if ($tokenOneName == 'unknown' || $tokenTwoName == 'unknown') {
                continue;
            }

            $protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
                'apy' => round($record['apy'], 5),
                'tvl' => round($record['liquidity'], 5),
            ]);
        }

        $this->setPopularTokens();
    }
}
