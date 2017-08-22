<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayerFavouriteFutsals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_favourite_futsal', function (Blueprint $table) {
            $table->integer('futsal_id')->unsigned();
            $table->foreign('futsal_id')->references('id')->on('futsals');
            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('player_profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_favorite_futsal');
    }
}
