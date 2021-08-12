<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_mode',
        'wins',
        'losses',
        'draws',
        'points',
        'competitor_id',
        'rank_id'
    ];
}
