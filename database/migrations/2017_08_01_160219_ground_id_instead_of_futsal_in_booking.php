<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroundIdInsteadOfFutsalInBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_bookings', function($table) {
            $table->integer('ground_id')->nullable()->unsigned();
            $table->foreign('ground_id')->references('id')->on('grounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_bookings', function($table) {
            $table->dropForeign(['ground_id']);
            $table->dropColumn('ground_id');
        });
    }
}
