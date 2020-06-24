<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePrazoNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->string('prazo')->nullable()->default(null)->change();
            $table->boolean('estado')->default(false)->change();
            $table->boolean('estado')->default(false)->change();
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('tarefas', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->default(null);
        });

        Schema::table('tarefas', function (Blueprint $table) {
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
        Schema::table('tarefas', function (Blueprint $table) {
            //
        });
    }
}
