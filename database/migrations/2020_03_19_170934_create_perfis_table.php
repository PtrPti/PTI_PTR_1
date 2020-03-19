<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->renameColumn('n_aluno', 'numero');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('perfil_id')->unsigned();
            $table->integer('departamento_id')->unsigned();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('perfil_id')->references('id')->on('perfis')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
        });

        Schema::table('cursos', function (Blueprint $table) {
            $table->integer('departamento_id')->unsigned();
        });

        Schema::table('cursos', function (Blueprint $table) {
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['perfil_id']);
            $table->dropForeign(['departamento_id']);
            $table->dropColumn('perfil_id');
            $table->dropColumn('departamento_id');
        });
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['departamento_id']);
            $table->dropColumn('departamento_id');
        });
        Schema::dropIfExists('perfis');
    }
}
