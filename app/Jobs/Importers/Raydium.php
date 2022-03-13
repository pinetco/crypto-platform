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

class Raydium extends Importer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function getProtocol(): Protocol
    {
        return Protocol::firstOrCreate([
            'name' => 'Raydium',
            'icon_path' => 'icons/raydium.svg',
            'url' => 'https://raydium.io/farms',
        ]);
    }

    public function getData(): Collection
    {
        return Http::get('https://api.raydium.io/v2/main/pairs')->collect();
    }

    public function import($record)
    {
        list($tokenOneName, $tokenTwoName) = explode('-', $record['name']);

        if ($tokenOneName == 'unknown' || $tokenTwoName == 'unknown') {
            return;
        }

        $this->protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
            'apr' => round($record['apr30d'], 5),
            'tvl' => round($record['liquidity'], 5),
        ]);
    }
}
