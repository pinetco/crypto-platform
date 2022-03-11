<?php

namespace Database\Seeders;

use App\Models\Token;
use App\Models\TokenType;
use Illuminate\Database\Seeder;

class UpdateTokenTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Token::all() as $token) {
            $token->token_type_id = TokenType::identify($token->name)->id;
            $token->save();
        }
    }
}
