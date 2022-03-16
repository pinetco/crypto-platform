<?php

namespace App\Models;

use App\Services\TokenTypeIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TokenType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'is_visible' => 'bool',
    ];

    const ORIGINAL = 'original',
        STABLE = 'stable',
        LIQUID_STACKED = 'liquid_stacked',
        BRIDGED = 'bridged',
        OTHER = 'other';

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public static function identify($tokenName)
    {
        return self::where('identifier', TokenTypeIdentifier::make($tokenName)->get())->first();
    }
}
