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
                'identifier' => PairType::SINGLE_SIDED_STABLE,
                'name' => 'Single sided Stablecoin',
            ],
            [
                'identifier' => PairType::SINGLE_SIDED_OTHER,
                'name' => 'Single sided Other',
            ],
            [
                'identifier' => PairType::STABLE_TO_STABLE,
                'name' => 'Stablecoin - Stablecoin Pair',
            ],
            [
                'identifier' => PairType::STABLE_TO_OTHER,
                'name' => 'Stablecoin - Other Pair',
            ],
            [
                'identifier' => PairType::SINGLE_SIDED_SOL,
                'name' => 'Single sided SOL',
            ],
            [
                'identifier' => PairType::SOL_TO_STABLE,
                'name' => 'SOL - Stablecoin Pair',
            ],
            [
                'identifier' => PairType::SOL_TO_SOL,
                'name' => 'SOL - SOL Pair',
            ],
            [
                'identifier' => PairType::SOL_TO_BTC_ETH,
                'name' => 'SOL - BTC/ETH Pair',
            ],
            [
                'identifier' => PairType::SOL_TO_OTHER,
                'name' => 'SOL - Other Pair',
            ],
            [
                'identifier' => PairType::OTHER_TO_OTHER,
                'name' => 'Other - Other Pair',
            ],
            [
                'identifier' => PairType::SINGLE_SIDED_BTC_ETH,
                'name' => 'Single sided BTC/ETH',
            ],
            [
                'identifier' => PairType::BTC_ETH_TO_OTHER,
                'name' => 'BTC/ETH - Other Pair',
            ],
            [
                'identifier' => PairType::BTC_ETH_TO_STABLE,
                'name' => 'BTC/ETH - Stablecoin Pair',
            ],
            [
                'identifier' => PairType::BTC_ETH_TO_BTC_ETH,
                'name' => 'BTC/ETH - BTC/ETH Pair',
            ]
        ];

        foreach ($data as $record) {
            PairType::create($record);
        }
    }
}
