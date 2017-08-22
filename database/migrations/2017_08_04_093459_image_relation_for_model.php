<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageRelationForModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $changeAbleTables=array(1=>'users',2=>'futsals');
        foreach ($changeAbleTables as $index=>$changeAbleTable){
            Schema::table($changeAbleTable, function($table)use($index) {
                $table->integer('avatar_id')->default($index)->unsigned();
                $table->foreign('avatar_id')->references('id')->on('images');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $changeAbleTables=array('users','futsals');

        foreach ($changeAbleTables as $changeAbleTable){
            Schema::table($changeAbleTable, function($table) {
                $table->dropForeign(['avatar_id']);
                $table->dropColumn('avatar_id');
            });
        }
    }
}
