<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMatchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('match_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('championship_id');
            $table->unsignedBigInteger('clan_id');

            $table->foreign('championship_id')->references('id')->on('championships');
            $table->foreign('clan_id')->references('id')->on('clans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('match_histories', function (Blueprint $table) {
            $table->dropColumn('clan_id');
            $table->dropColumn('championship_id');
        });
    }
}
