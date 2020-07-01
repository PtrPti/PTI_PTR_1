<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CeateTableTarefasFicheiros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('tarefas_ficheiros', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nome');
            $table->string('link');
        });

        Schema::table('tarefas_ficheiros', function (Blueprint $table) {
            $table->integer('tarefa_id')->unsigned();
        });

        Schema::table('tarefas_ficheiros', function (Blueprint $table) {
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->onDelete('cascade');
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->string('notas', 4000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('tarefas_ficheiros');

        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropColumn('notas');
        });
    }
}