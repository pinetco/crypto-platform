<?php

namespace App\Importers;

use App\Models\Token;
use App\Models\TokenCombination;
use App\Traits\Makeable;

abstract class Importer
{
    use Makeable;
}
