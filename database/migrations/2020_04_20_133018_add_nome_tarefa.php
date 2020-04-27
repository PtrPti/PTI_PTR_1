<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNomeTarefa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('tarefas', function (Blueprint $table) {
            $table->integer('tarefa_id')->unsigned()->nullable();
            $table->boolean('estado');
            $table->string('nome')->nullable();
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign(['tarefa_id']);
            $table->dropColumn('tarefa_id');
        });
    }
}
