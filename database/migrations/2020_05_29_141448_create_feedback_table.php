<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mensagem');
            $table->timestamps();
        });

        Schema::table('feedback', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned()->nullable();
           
        });

        Schema::table('feedback', function (Blueprint $table) {

            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');

        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
            
        });
    }
}
