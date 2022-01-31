<?php

namespace App\Importers;

use App\Models\Farm;
use Http;

class RaydiumImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://api.raydium.io/pairs');

        $farm = Farm::firstOrCreate([
            'name' => 'Raydium',
            'url' => 'https://raydium.io/farms',
        ]);

        foreach ($response->collect() as $record) {
            list($tokenOneName, $tokenTwoName) = explode('-', $record['name']);

            if ($tokenOneName == 'unknown' || $tokenTwoName == 'unknown') {
                continue;
            }

            $farm->importTokens($tokenOneName, $tokenTwoName, $record['apy']);
        }

        $this->setPopularTokens();
    }
}
