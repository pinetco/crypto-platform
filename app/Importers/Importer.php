<?php

namespace App\Importers;

use App\Models\Token;
use App\Models\TokenCombination;
use App\Traits\Makeable;

abstract class Importer
{
    use Makeable;

    protected function setPopularTokens()
    {
        Token::has('combinations', '>', 3)
            ->inRandomOrder()
            ->take(7)
            ->get()
            ->each
            ->update(['is_popular' => true]);
    }
}
