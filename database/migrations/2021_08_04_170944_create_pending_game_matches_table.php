<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_game_matches', function (Blueprint $table) {
            $table->id();
            $table->string('game_mode');
            $table->unsignedBigInteger('winner'); //eu nao usei foreign key nem em winner nem em loser, pois dependendo do campeonato a foreign se referenciará para ou clans ou users
            $table->unsignedBigInteger('loser');
            $table->integer('total_score_winner');
            $table->integer('total_score_loser');
            $table->integer('delta_winner');
            $table->integer('delta_loser');
            $table->boolean('draw')->nullable();
            $table->text('submitter_comment')->nullable();
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
        Schema::dropIfExists('pending_game_matches');
    }
}