<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysFks3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('employees', function(Blueprint $table){
        $table->foreign('government_agency_id')->references('id')->on('government_agencies')->onUpdate('cascade')->onDelete('set null');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function(Blueprint $table){
          $table->dropForeign(['government_agency_id']);
        });
    }
}
