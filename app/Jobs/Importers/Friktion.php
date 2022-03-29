<?php

namespace App\Jobs\Importers;

use Http;
use App\Models\Protocol;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class Friktion extends Importer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tvl = [];

    public function getProtocol(): Protocol
    {
        return Protocol::firstOrCreate([
            'name' => 'Friktion',
            'icon_path' => 'icons/friktion.png',
            'url' => 'https://app.friktion.fi/analytics',
        ]);
    }

    public function getData(): Collection
    {
        $response = Http::get('https://raw.githubusercontent.com/Friktion-Labs/mainnet-tvl-snapshots/main/friktionSnapshot.json')->collect();

        $this->tvl = $response->get('usdValueByGlobalId', []);

        return collect($response->get('allMainnetVolts'));
    }

    public function import($record)
    {
        $this->protocol->importTokenPairs($record['underlyingTokenSymbol'], null, [
            'apr' => round($record['apy'], 5),
            'tvl' => round($this->tvl[$record['globalId']], 5),
        ]);
    }
}
