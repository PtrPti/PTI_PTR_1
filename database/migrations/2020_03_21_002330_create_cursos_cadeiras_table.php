<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosCadeirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos_cadeiras', function (Blueprint $table) {
            $table->increments('id');            
        });

        Schema::table('cursos_cadeiras', function (Blueprint $table) {
            $table->integer('curso_id')->unsigned();
            $table->integer('cadeira_id')->unsigned();
        });

        Schema::table('cursos_cadeiras', function (Blueprint $table) {
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('cadeira_id')->references('id')->on('cadeiras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos_cadeiras');
    }
}
