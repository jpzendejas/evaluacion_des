<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysFks1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function(Blueprint $table){
          $table->foreign('perfomance_indicator_id')->references('id')->on('perfomance_indicators')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function(Blueprint $table){
          $table->dropForeign(['perfomance_indicator_id']);
        });
    }
}
