<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableForFutsalDayWisePricingWithTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('futsal_price_day_time', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('futsal_id')->unsigned();
            $table->foreign('futsal_id')->references('id')->on('futsals');
            $table->integer('day_id')->unsigned();
            $table->foreign('day_id')->references('id')->on('week_day');
            $table->integer('time_id')->unsigned();
            $table->foreign('time_id')->references('id')->on('book_time');
            $table->decimal('price', 8, 2);
            $table->integer('batch');
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
        Schema::dropIfExists('futsal_price_day_time');
    }
}
