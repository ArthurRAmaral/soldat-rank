<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->id();
            $table->json('competitors');
            $table->unsignedBigInteger('winner'); //eu nao usei foreign key nem em winner nem em loser, pois dependendo do campeonato a foreign se referenciará para ou clans ou users
            $table->unsignedBigInteger('loser');
            $table->boolean('draw');
            $table->string('img');
            $table->date('match_date');
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
        Schema::dropIfExists('game_matches');
    }
}
