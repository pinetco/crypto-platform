<?php

namespace Database\Seeders;

use App\Jobs\Importers\Friktion;
use App\Jobs\Importers\Orca;
use App\Jobs\Importers\Raydium;
use App\Jobs\Importers\SolanaLido;
use App\Jobs\Importers\TulipGarden;
use App\Jobs\SetPopularTokens;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(TokenTypesSeeder::class);
        $this->call(PairTypesSeeder::class);

        // TODO: remove later
        Raydium::dispatch();
        TulipGarden::dispatch();
        Orca::dispatch();
        Friktion::dispatch();
        // SolanaLido::dispatch(); // disabled because it has data from multiple protocols

        SetPopularTokens::dispatch();
    }
}
