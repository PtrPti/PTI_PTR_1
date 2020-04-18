<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposFicheirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos_ficheiros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('link');
            $table->boolean('is_folder');
        });

        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned();
            $table->integer('pasta_id')->unsigned();
        });

        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->foreign('pasta_id')->references('id')->on('grupos_ficheiros')->onDelete('cascade');
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->integer('projeto_id')->unsigned();
            $table->integer('grupo_id')->unsigned();
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
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
        Schema::dropIfExists('grupos_ficheiros');

        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign(['projeto_id']);
            $table->dropForeign(['grupo_id']);
            $table->dropColumn('projeto_id');
            $table->dropColumn('grupo_id');
        });
    }
}
