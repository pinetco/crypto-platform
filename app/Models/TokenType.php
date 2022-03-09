<?php

namespace App\Models;

use App\Services\TokenTypeIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TokenType extends Model
{
    use HasFactory;

    public $timestamps = false;

    const ORIGINAL = 'original',
        STABLE = 'stable',
        LIQUID_STACKED = 'liquid_stacked',
        BRIDGED = 'bridged',
        OTHER = 'other';

    public static function identify($tokenName)
    {
        return self::where('identifier', TokenTypeIdentifier::make($tokenName)->get())->first();
    }
}
