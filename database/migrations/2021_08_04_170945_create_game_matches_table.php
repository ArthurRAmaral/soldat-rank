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
            $table->string('game_mode');
            $table->unsignedBigInteger('winner'); //eu nao usei foreign key nem em winner nem em loser, pois dependendo do campeonato a foreign se referenciará para ou clans ou users
            $table->unsignedBigInteger('loser');
            $table->integer('total_score_winner');
            $table->integer('total_score_loser');
            $table->integer('delta_winner');
            $table->integer('delta_loser');
            $table->boolean('draw')->nullable();
            $table->boolean('is_validated')->nullable();
            $table->text('validator_comment')->nullable();
            $table->text('submitter_comment')->nullable();
            $table->date('match_date');
            $table->date('submitted_date');
            $table->softDeletes();
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
