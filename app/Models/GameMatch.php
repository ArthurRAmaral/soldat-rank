<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'championship_id',
        'competitors',
        'winner',
        'loser',
        'draw',
        'img',
        'match_date'
    ];
}
