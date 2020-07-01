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
        Schema::create('users_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('numero')->unique();
            $table->integer('grau_academico_id')->nullable()->unsigned();
            $table->integer('departamento_id')->unsigned();
            $table->integer('curso_id')->nullable()->unsigned();
            $table->dateTime('data_nascimento');
            $table->timestamps();
        });

        Schema::table('users_info', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
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
        Schema::dropIfExists('users_info');
    }
}
