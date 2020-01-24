<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeysFks2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_answers', function(Blueprint $table){
          $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('set null');
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
      Schema::table('question_answers', function(Blueprint $table){
        $table->dropForeign(['question_id']);
        $table->dropForeign(['answer_id']);
      });
    }
}
