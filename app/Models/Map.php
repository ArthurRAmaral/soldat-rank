<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_match_id',
        'screen',
        'score_winner',
        'score_loser',
        'map_name_id',
    ];
}
