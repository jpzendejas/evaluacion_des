<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeQuestionAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_question_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->integer('answer_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_question_answers');
    }
}
