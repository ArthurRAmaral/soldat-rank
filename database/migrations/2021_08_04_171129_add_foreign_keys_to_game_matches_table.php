<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_matches', function (Blueprint $table) {
            $table->unsignedBigInteger('rank_id');
            $table->unsignedBigInteger('submitted_by');
            $table->unsignedBigInteger('validated_by');

            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->foreign('submitted_by')->references('id')->on('users');
            $table->foreign('validated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_matches', function (Blueprint $table) {
            $table->dropColumn('rank_id');
            $table->dropColumn('submitted_by');
            $table->dropColumn('validated_by');
            $table->dropColumn('match_history_id');
        });
    }
}
