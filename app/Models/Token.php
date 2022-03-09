<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function token_type()
    {
        return $this->belongsTo(TokenType::class);
    }

    public function combinations()
    {
        return $this->belongsToMany(self::class, TokenCombination::class, 'from_token_id', 'to_token_id');
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public static function getToken($tokenName)
    {
        return Token::firstOrCreate([
            'name' => $tokenName
        ], [
            'token_type_id' => TokenType::identify($tokenName)->id,
        ]);
    }
}
