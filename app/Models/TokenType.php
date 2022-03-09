<?php

namespace App\Models;

use Arr;
use Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TokenType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function identify($tokenName)
    {
        $type = 'other';

        if (Arr::has(['USD', 'DAI', 'MIM', 'FRAX', 'UST', 'MAI', 'CASH'], $tokenName)) {
            $type = 'stable';
        } elseif (Str::startsWith($tokenName, ['aa', 'ab', 'ac', 'ae', 'af', 'ag', 'ah', 'ap', 'at', 'so', 'sol', 'we', 'wb', 'wib', 'wt', 'wh'])) {
            $type = 'bridged';
        } elseif (Str::startsWith($tokenName, ['a', 'm', 'e', 'c', 'p', 'prt', 'ren', 's', 'scn', 'st', 'w', 'wst', 'x', 'y'])) {
            $type = 'liquid_stacked';
        } elseif (true) {
            // TODO
            $type = 'original';
        }

        return self::where('identifier', $type)->first();
    }
}
