<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosFicheirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos_ficheiros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::table('projetos_ficheiros', function (Blueprint $table) {
            $table->integer('projeto_id')->unsigned();
        });

        Schema::table('projetos_ficheiros', function (Blueprint $table) {
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projetos_ficheiros');
    }
}
