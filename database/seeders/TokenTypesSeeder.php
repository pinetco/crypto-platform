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
            'original' => 'Original Coin',
            'stable' => 'Stable Coin',
            'liquid_stacked' => 'Liquid Stacked Coin',
            'bridged' => 'Bridged Coin',
            'other' => 'Other',
        ];

        foreach ($data as $identifier => $name) {
            TokenType::create(compact('identifier', 'name'));
        }
    }
}
