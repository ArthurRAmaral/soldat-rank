<?php

use App\Models\MatchHistory;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InsertDataToRanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('ranks')->insert(array(
            array('title' => "Primeira Temporada de DM",
            'game_mode' => 'DM',
            'start' => Carbon::now('America/Sao_Paulo')->format('Y-m-d'),
            'end' => '2022-01-01',
            'is_active' => 1,
            'created_at' => Carbon::now('America/Sao_Paulo'),
            'updated_at' => Carbon::now('America/Sao_Paulo')),

            array('title' => "Primeira Temporada de TM",
            'game_mode' => 'TM',
            'start' => Carbon::now('America/Sao_Paulo')->format('Y-m-d'),
            'end' => '2022-01-01',
            'is_active' => 1,
            'created_at' => Carbon::now('America/Sao_Paulo'),
            'updated_at' => Carbon::now('America/Sao_Paulo')),
        ));

        DB::table('users')->insert(
            ['name' => 'SUPER',
            'nickname' => 'SUPER',
            'email' => 'super@super.com',
            'password' => Hash::make(env('SUPERUSER_PASS')),
            'phone' => 66666666,
            'is_superuser' => 1,
            'created_at' => Carbon::now('America/Sao_Paulo'),
            'updated_at' => Carbon::now('America/Sao_Paulo')]
        );
        
        MatchHistory::create([
            'game_mode' => 'DM',
            'wins' => 0,
            'losses' => 0,
            'draws' => 0,
            'points' => 0,
            'competitor_id' => 1,
            'rank_id' => 1
        ]);
            
    }
}
