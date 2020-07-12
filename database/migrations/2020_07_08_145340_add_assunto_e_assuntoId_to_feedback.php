<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssuntoEAssuntoIdToFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('mensagem');
            $table->integer('mensagem_id')->unsigned()->nullable()->default(null);
            $table->integer('user_id')->unsigned()->nullable()->default(null);
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('mensagem_id')->references('id')->on('feedback')->onDelete('cascade');
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropColumn('mensagem_grupo');
        });
    }
}
