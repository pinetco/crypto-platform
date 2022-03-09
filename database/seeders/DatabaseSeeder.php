<?php

namespace Database\Seeders;

use App\Importers\OrcaImporter;
use App\Importers\RaydiumImporter;
use App\Importers\SolanaLidoImporter;
use App\Importers\SolfarmImporter;
use App\Models\Token;
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
        SolfarmImporter::make()->handle();
        OrcaImporter::make()->handle();
        SolanaLidoImporter::make()->handle();
    }
}
