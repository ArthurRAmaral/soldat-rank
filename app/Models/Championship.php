<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'competitors',
        'game_mode',
        'matches',
        'start',
        'end'
    ];
}
