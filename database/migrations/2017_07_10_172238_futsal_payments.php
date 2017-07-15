<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FutsalPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('futsal_payments', function (Blueprint $table) {
            $table->integer('futsal_id')->unsigned();
            $table->foreign('futsal_id')->references('id')->on('futsals');
            $table->integer('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payment_gateway');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('futsal_payments');
    }
}
