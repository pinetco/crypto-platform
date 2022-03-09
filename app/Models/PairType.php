<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function identify($tokenOne, $tokenTwo)
    {
        // TODO
        return self::first();
    }
}
