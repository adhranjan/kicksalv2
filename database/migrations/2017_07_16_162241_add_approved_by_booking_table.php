<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedByBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_bookings', function($table) {
            $table->integer('approved_by')->nullable()->unsigned();
            $table->foreign('approved_by')->references('id')->on('staff_profile');
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
            $table->dropForeign(['approved_by']);
            $table->dropColumn('approved_by');
        });
    }
}
