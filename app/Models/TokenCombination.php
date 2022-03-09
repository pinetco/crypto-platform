<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenCombination extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    public function pair_type()
    {
        return $this->belongsTo(PairType::class);
    }

    public function from_token()
    {
        return $this->belongsTo(Token::class);
    }

    public function to_token()
    {
        return $this->belongsTo(Token::class);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->whereHas('from_token', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            })->orWhereHas('to_token', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeWhereHasTokens($query, $key, $value)
    {
        return $query->where(function ($q) use ($key, $value) {
            $q->whereHas('from_token', function ($q) use ($key, $value) {
                $q->where($key, $value);
            })->orWhereHas('to_token', function ($q) use ($key, $value) {
                $q->where($key, $value);
            });
        });
    }
}
