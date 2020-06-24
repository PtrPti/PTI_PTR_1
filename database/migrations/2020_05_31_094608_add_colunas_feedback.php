<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunasFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->renameColumn('user_id', 'docente_id');
            $table->renameColumn('mensagem', 'mensagem_grupo');
            $table->string('mensagem_docente')->default(NULL);
        });

        Schema::create('feedback_ficheiros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feedback_id')->unsigned();
            $table->integer('tarefa_ficheiro_id')->unsigned()->nullable()->default(NULL);
            $table->integer('grupo_ficheiro_id')->unsigned()->nullable()->default(NULL);
        });

        Schema::table('feedback_ficheiros', function (Blueprint $table) {
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade');
            $table->foreign('grupo_ficheiro_id')->references('id')->on('grupos_ficheiros')->onDelete('cascade');
            $table->foreign('tarefa_ficheiro_id')->references('id')->on('tarefas_ficheiros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn('mensagem_docente');
            $table->renameColumn('docente_id','user_id');
            $table->renameColumn('mensagem_grupo','mensagem');
        });

        Schema::dropIfExists('feedback_ficheiros');
    }
}
