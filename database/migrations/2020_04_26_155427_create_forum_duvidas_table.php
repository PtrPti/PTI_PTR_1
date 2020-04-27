<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumDuvidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_duvidas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('assunto');
            $table->string('primeiro_user');
            $table->string('ultimo_user');
            $table->string('cadeira_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_duvidas');
    }
}
