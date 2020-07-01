<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnoLetivoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->integer('ano_letivo_id')->unsigned();
        });

        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->foreign('ano_letivo_id')->references('id')->on('ano_letivo')->onDelete('cascade');
        });

        Schema::table('cursos_cadeiras', function (Blueprint $table) {
            $table->integer('semestre_id')->unsigned();
        });

        Schema::table('cursos_cadeiras', function (Blueprint $table) {
            $table->foreign('semestre_id')->references('id')->on('semestre')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursos_cadeiras', function (Blueprint $table) {
            $table->dropForeign(['semestre_id']);
            $table->dropColumn('semestre_id');
        });

        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->dropForeign(['ano_letivo_id']);
            $table->dropColumn('ano_letivo_id');
        });
    }
}
