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
            //$table->unsignedBigInteger('camp_id');
            $table->json('matches');
            $table->integer('wins');
            $table->integer('losses');
            $table->integer('draws');
            $table->integer('points');
            //$table->unsignedBigInteger('clan_id');
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
