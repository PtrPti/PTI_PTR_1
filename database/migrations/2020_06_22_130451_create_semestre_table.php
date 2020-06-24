<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestre', function (Blueprint $table) {
            $table->increments('id');
            $table->string('semestre');
            $table->integer('dia_inicio');
            $table->integer('mes_inicio');
            $table->integer('ano_inicio');
            $table->integer('dia_fim');
            $table->integer('mes_fim');
            $table->integer('ano_fim');
            $table->integer('ano_letivo_id')->unsigned();
        });

        Schema::table('semestre', function (Blueprint $table) {
            $table->foreign('ano_letivo_id')->references('id')->on('ano_letivo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semestre');
    }
}
