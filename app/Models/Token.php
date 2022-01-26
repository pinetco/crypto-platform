<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function combinations()
    {
        return $this->belongsToMany(self::class, TokenCombination::class, 'from_token_id', 'to_token_id');
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }
}
