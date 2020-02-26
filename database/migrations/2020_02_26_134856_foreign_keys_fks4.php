<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysFks4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('employee_question_answers', function(Blueprint $table){
        $table->foreign('answer_id')->references('id')->on('answers')->onUpdate('cascade')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('employee_question_answers', function(Blueprint $table){
        $table->dropForeign(['answer_id']);
      });
    }
}
