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

class Orca extends Importer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function getProtocol(): Protocol
    {
        return Protocol::firstOrCreate([
            'name' => 'Orca',
            'icon_path' => 'icons/orca.svg',
            'url' => 'https://www.orca.so/pools',
        ]);
    }

    public function getData(): Collection
    {
        return Http::get('https://api.orca.so/allPools')->collect();
    }

    public function import($record)
    {
        if (empty($record['poolId'])) {
            return;
        }

        list($tokenOneName, $tokenTwoName) = explode('/', str_replace(['[aquafarm]', '[stable]'], '', $record['poolId']));

        $this->protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
            'apy' => round($record['apy']['month'], 5),
            'tvl' => round($record['volume']['month'], 5),
        ]);
    }
}
