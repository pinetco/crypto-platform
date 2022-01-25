<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenCombination extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function from_token()
    {
        return $this->belongsTo(Token::class);
    }

    public function to_token()
    {
        return $this->belongsTo(Token::class);
    }
}
