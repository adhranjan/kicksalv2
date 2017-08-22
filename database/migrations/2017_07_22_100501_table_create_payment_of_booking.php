<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCreatePaymentOfBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_for_booking', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('game_bookings');

            $table->decimal('advance_booking', 8, 2)->default(0);
            $table->decimal('hand_cash_amount', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);

            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff_profile');

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
        Schema::dropIfExists('payment_for_booking');
    }


}
