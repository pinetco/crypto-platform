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

class SolanaLido extends Importer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function getProtocol(): Protocol
    {
        return Protocol::firstOrCreate([
            'name' => 'Solana Lido',
            'icon_path' => 'icons/lido.svg',
            'url' => 'https://solana.lido.fi/defi',
        ]);
    }

    public function getData(): Collection
    {
        return Http::get('https://solana.lido.fi/api/defi')->collect();
    }

    public function import($record)
    {
        $tokenOneName = $record['PoolLeftToken'];
        $tokenTwoName = $record['PoolRightToken'];

        $this->protocol->importTokenPairs($tokenOneName, $tokenTwoName, [
            'apy' => round($record['totalApy'], 5),
            'apr' => round($record['totalApr'], 5),
            'tvl' => round($record['totalValueLockedInUsd'], 5),
        ]);
    }
}
