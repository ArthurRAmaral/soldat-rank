<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_histories', function (Blueprint $table) {
            $table->id();
            $table->string('game_mode');
            $table->integer('wins');
            $table->integer('losses');
            $table->integer('draws');
            $table->integer('points'); //total delta points
            $table->unsignedBigInteger('competitor_id'); //clan or user, it depends the game_mode

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_histories');
    }
}
