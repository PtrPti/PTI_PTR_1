<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->boolean('allDay');
            $table->string('title');
        });

        Schema::table('calendario', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned()->nullable();
        });

        Schema::table('calendario', function (Blueprint $table) {
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendario');
    }
}
