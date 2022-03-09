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
            [
                'identifier' => 'single_sided_stable',
                'name' => 'Single sided Stablecoin',
                'token_combinations' => [
                    'stable',
                ],
            ],
            [
                'identifier' => 'single_sided_other',
                'name' => 'Single sided Other',
                'token_combinations' => [
                    'other',
                ],
            ],
            [
                'identifier' => 'stable_to_stable',
                'name' => 'Stablecoin-Stablecoin Pair',
                'token_combinations' => [
                    'stable', 'stable',
                ],
            ],
            [
                'identifier' => 'stable_to_other',
                'name' => 'Stablecoin-Other Pair',
                'token_combinations' => [
                    'stable', 'other',
                ],
            ],
            [
                'identifier' => 'single_sided_sol',
                'name' => 'Single sided SOL',
                'token_combinations' => [
                    'sol',
                ],
            ],
            [
                'identifier' => 'sol_to_stable',
                'name' => 'SOL-Stablecoin Pair',
                'token_combinations' => [
                    'sol', 'stable',
                ],
            ],
            [
                'identifier' => 'sol_to_sol',
                'name' => 'SOL-SOL Pair',
                'token_combinations' => [
                    'sol', 'sol',
                ],
            ],
        ];

        foreach ($data as $record) {
            PairType::create($record);
        }
    }
}
