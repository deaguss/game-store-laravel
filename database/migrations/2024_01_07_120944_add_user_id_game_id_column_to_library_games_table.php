<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('library_games', function (Blueprint $table) {
            $table->uuid('game_id')->after('id');
            $table->uuid('user_id')->after('game_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('library_games', function (Blueprint $table) {
            $table->dropForeign('library_games_game_id_foreign');
            $table->dropForeign('library_games_user_id_foreign');
            $table->dropColumn('game_id');
            $table->dropColumn('user_id');
        });
    }
};
