<?php

namespace Database\Seeders;

use App\Models\TokenType;
use Illuminate\Database\Seeder;

class TokenTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            TokenType::ORIGINAL => 'Original Coin',
            TokenType::STABLE => 'Stable Coin',
            TokenType::LIQUID_STACKED => 'Liquid Stacked Coin',
            TokenType::BRIDGED => 'Bridged Coin',
            TokenType::OTHER => 'Other',
        ];

        foreach ($data as $identifier => $name) {
            TokenType::create(compact('identifier', 'name'));
        }
    }
}
