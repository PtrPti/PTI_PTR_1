<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnoLetivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ano_letivo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ano');
            $table->integer('mes_inicio');
            $table->integer('ano_inicio');
            $table->integer('mes_fim');
            $table->integer('ano_fim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ano_letivo');
    }
}
