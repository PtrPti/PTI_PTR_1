<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegisterInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::table('faculdades', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::table('universidades', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::table('grupos', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('curso_id')->unsigned();
            $table->integer('n_aluno')->unique();
            $table->integer('grau_academico_id')->unsigned();
            $table->dateTime('data_nascimento');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('grau_academico_id')->references('id')->on('graus_academicos')->onDelete('cascade');
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
            $table->dropForeign(['curso_id']);
            $table->dropForeign(['grau_academico_id']);
            $table->dropColumn('curso_id');
            $table->dropColumn('grau_academico_id');
            $table->dropColumn('data_nascimento');
        });
    }
}
