<?php

namespace Database\Seeders;

use App\Models\PairType;
use App\Models\TokenCombination;
use Illuminate\Database\Seeder;

class UpdatePairTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (TokenCombination::get() as $tokenCombination) {
            $tokenCombination->pair_type_id = PairType::identify($tokenCombination->from_token, $tokenCombination->to_token)->id;
            $tokenCombination->save();
        }
    }
}
