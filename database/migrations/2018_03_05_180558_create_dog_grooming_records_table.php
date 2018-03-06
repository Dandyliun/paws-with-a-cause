<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogGroomingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_grooming_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dog_id')->unsigned();
            $table->foreign('dog_id')->references('id')->on('dogs');
            $table->integer('grooming_service_id')->unsigned();
            $table->foreign('grooming_service_id')->references('id')->on('dog_groomings');
            $table->boolean('normality');
            $table->string('value');
            $table->mediumText('comments');
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
        Schema::dropIfExists('dog_grooming_records');
    }
}
