<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogHealthRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_health_records', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('dog_id')->references('id')->on('dogs');
            $table->foreign('attribute_id')->references('id')->on('dog_health');
            $table->foreign('performed_by')->references('id')->on('users');
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
        Schema::dropIfExists('dog_health_records');
    }
}
