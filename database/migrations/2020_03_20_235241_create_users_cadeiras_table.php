<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCadeirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_cadeiras', function (Blueprint $table) {
            $table->increments('id');            
        });

        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('cadeira_id')->unsigned();
        });

        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cadeira_id')->references('id')->on('cadeiras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_cadeiras');
    }
}
