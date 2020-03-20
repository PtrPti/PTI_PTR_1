<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['curso_id']);
            $table->dropForeign(['grau_academico_id']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->integer('curso_id')->nullable()->unsigned()->change();
            $table->integer('grau_academico_id')->nullable()->unsigned()->change();
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
            //
        });
    }
}
