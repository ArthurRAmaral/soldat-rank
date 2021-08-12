<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maps', function (Blueprint $table) {
            $table->unsignedBigInteger('game_match_id');
            $table->unsignedBigInteger('map_name_id');

            $table->foreign('game_match_id')->references('id')->on('game_matches');
            $table->foreign('map_name_id')->references('id')->on('map_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maps', function (Blueprint $table) {
            $table->dropColumn('game_match_id');
            $table->dropColumn('map_name_id');
        });
    }
}
