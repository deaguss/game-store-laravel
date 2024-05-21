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
        Schema::table('detail_cart_games', function (Blueprint $table) {
            $table->uuid('user_id')->after('id');
            $table->uuid('game_id')->after('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onDelete('restrict');
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
        Schema::table('detail_cart_games', function (Blueprint $table) {
            $table->dropForeign(['detail_cart_games_user_id_foreign']);
            $table->dropForeign(['detail_cart_games_game_id_foreign']);

            $table->dropColumn(['user_id', 'game_id']);
        });
    }
};
