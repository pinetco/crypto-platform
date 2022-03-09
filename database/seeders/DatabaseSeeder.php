<?php

namespace Database\Seeders;

use App\Importers\OrcaImporter;
use App\Importers\RaydiumImporter;
use App\Importers\SolanaLidoImporter;
use App\Importers\TulipGardenImporter;
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

        RaydiumImporter::make()->handle();
        TulipGardenImporter::make()->handle();
        OrcaImporter::make()->handle();
//        SolanaLidoImporter::make()->handle(); // disabled because it has data from multiple protocols

        SetPopularTokens::dispatch();
    }
}
