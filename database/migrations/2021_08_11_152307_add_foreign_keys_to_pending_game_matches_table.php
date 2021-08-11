<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPendingGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_game_matches', function (Blueprint $table) {
            $table->unsignedBigInteger('rank_id');
            $table->unsignedBigInteger('submitted_by');
            $table->unsignedBigInteger('validated_by');
            $table->unsignedBigInteger('match_history_id');

            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->foreign('submitted_by')->references('id')->on('users');
            $table->foreign('validated_by')->references('id')->on('users');
            $table->foreign('match_history_id')->references('id')->on('match_histories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_game_matches', function (Blueprint $table) {
            $table->dropColumn('rank_id');
            $table->dropColumn('submitted_by');
            $table->dropColumn('validated_by');
            $table->dropColumn('match_history_id');
        });
    }
}
