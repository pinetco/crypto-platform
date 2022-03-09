<?php

namespace Database\Seeders;

use App\Models\PairType;
use Illuminate\Database\Seeder;

class PairTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'single_sided_stable' => 'Single sided Stablecoin',
            'single_sided_other' => 'Single sided Other',
            'stable_to_stable' => 'Stablecoin-Stablecoin Pair',
            'stable_to_other' => 'Stablecoin-Other Pair',
            'single_sided_sol' => 'Single sided SOL',
            'sol_to_stable' => 'SOL-Stablecoin Pair',
            'sol_to_sol' => 'SOL-SOL Pair',
        ];

        foreach ($data as $identifier => $name) {
            PairType::create(compact('identifier', 'name'));
        }
    }
}
