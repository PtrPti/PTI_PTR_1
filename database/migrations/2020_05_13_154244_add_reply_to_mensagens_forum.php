<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplyToMensagensForum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_mensagens', function (Blueprint $table) {
            $table->integer('resposta_a')->unsigned()->nullable();
        });

        Schema::table('forum_mensagens', function (Blueprint $table) {
            $table->foreign('resposta_a')->references('id')->on('forum_mensagens')->onDelete('cascade');
        });

        Schema::table('tarefas_ficheiros', function (Blueprint $table) {
            $table->string('link')->nullable()->change();
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->string('notas')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_mensagens', function (Blueprint $table) {
            $table->dropForeign(['resposta_a']);
            $table->dropColumn(['resposta_a']);
        });
    }
}
