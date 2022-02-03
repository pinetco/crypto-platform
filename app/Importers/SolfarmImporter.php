<?php

namespace App\Importers;

use App\Models\Farm;
use Http;

class SolfarmImporter extends Importer
{
    public function handle()
    {
        $response = Http::get('https://api.solfarm.io/pairs?pair=WOOF-RAY,SYP-USDC,SYP-RAY,SYP-SOL,LIQ-USDC,LIQ-RAY,MNDE-mSOL,mSOL-USDC,mSOL-USDT,mSOL-RAY,ETH-mSOL,BTC-mSOL,LARIX-RAY,LARIX-USDC,GRAPE-USDC,ATLAS-USDC,POLIS-USDC,ATLAS-RAY,POLIS-RAY,TULIP-USDC,RAY-USDT,RAY-USDC,RAY-SRM,RAY-SOL,RAY-ETH,MEDIA-USDC,SAMO-RAY,COPE-USDC,MER-USDC,ALEPH-USDC,LIKE-USDC,BOP-RAY,ROPE-USDC,SNY-USDC,SLRS-USDC,MNGO-USDC,RAY-SRM-DUAL,STEP-USDC,KIN-RAY,FIDA-RAY,OXY-RAY,MAPS-RAY,FRKT-SOL,weWETH-SOL,weWETH-USDC,weUNI-USDC,weSUSHI-USDC,SRM-USDC,STARS-USDC,weAXS-USDC,weDYDX-USDC,weSHIB-USDC,weSAND-USDC,weMANA-USDC,CAVE-USDC,GENE-USDC,GENE-RAY,SONAR-USDC,CWAR-USDC,DFL-USDC,APT-USDC,SHILL-USDC,wbWBNB-USDC,wePEOPLE-USDC,MIMO-SOL,SOL-USDC-RAY,SOL-USDT-RAY,SOL-USDC,SOL-USDT,REAL-USDC,CRWNY-USDC,CRWNY-RAY,RUN-USDC,TTT-USDC,BOKU-USDC,XTAG-USDC,MBS-USDC,PRISM-USDC,CHICKS-USDC,MEAN-RAY,SVT-USDC,SLC-USDC');

        $farm = Farm::firstOrCreate([
            'name' => 'Tulip Garden',
            'url' => 'https://tulip.garden/vaults',
        ]);

        foreach ($response->collect() as $record) {
            if (empty($record['name'])) {
                continue;
            }

            list($tokenOneName, $tokenTwoName) = explode('-', $record['name']);

            $farm->importTokens($tokenOneName, $tokenTwoName, [
                'apy' => round($record['apy'], 5),
                'liquidity' => round($record['liquidity'], 5),
            ]);
        }

        $this->setPopularTokens();
    }
}
