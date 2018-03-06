<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogExerciseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_exercise_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dog_id')->unsigned();
            $table->foreign('dog_id')->references('id')->on('dogs');
            $table->integer('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('id')->on('dog_exercises');
            $table->mediumText('comments');
            $table->boolean('normality');
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
        Schema::dropIfExists('dog_exercise_records');
    }
}
