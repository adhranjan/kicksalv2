<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_bookings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('player_profile');


            $table->integer('book_time')->nullable()->unsigned();
            $table->foreign('book_time')->references('id')->on('book_time');

            $table->date('game_day');
            $table->tinyInteger('status');

            $table->string('booking_code')->nullable();
            $table->integer('price_batch');
            $table->integer('payment_status');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_bookings');
    }
}
