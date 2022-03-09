<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'token_combinations' => 'array',
    ];

    public static function identify(Token $tokenOne, Token $tokenTwo)
    {
        $tokenOneName = strtolower($tokenOne->name);
        $tokenTwoName = strtolower($tokenTwo->name);
        $tokenOneType = $tokenOne->token_type->identifier;
        $tokenTwoType = $tokenTwo->token_type->identifier;

        $identifier = 'single_sided_stable'; // TODO: for time being

        if ($tokenOneType === 'stable' && $tokenTwoType === 'stable') {
            $identifier = 'stable_to_stable';
        } elseif (($tokenOneType === 'stable' || $tokenTwoType === 'stable') && ($tokenOneType === 'other' || $tokenTwoType === 'other')) {
            $identifier = 'stable_to_other';
        } elseif (($tokenOneName === 'sol' || $tokenTwoName === 'sol') && ($tokenOneType === 'stable' || $tokenTwoType === 'stable')) {
            $identifier = 'sol_to_stable';
        } elseif ($tokenOneName === 'sol' && $tokenTwoName === 'sol') {
            $identifier = 'sol_to_sol';
        }

        return self::where('identifier', $identifier)->first();
    }
}
