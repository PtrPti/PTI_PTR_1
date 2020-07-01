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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('curso_id')->nullable()->unsigned();
            $table->integer('numero')->unique();
            $table->integer('grau_academico_id')->nullable()->unsigned();
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
            $table->dropColumn('numero');
            $table->dropColumn('data_nascimento');
        });
    }
}
