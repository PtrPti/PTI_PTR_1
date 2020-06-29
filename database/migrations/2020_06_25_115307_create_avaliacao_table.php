<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mensagem_criterios', 200);
            $table->timestamps();
        });

        Schema::table('avaliacao', function (Blueprint $table) {
            $table->integer('cadeira_id')->unsigned();
        });

        Schema::table('avaliacao', function (Blueprint $table) {
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
        Schema::dropIfExists('avaliacao');
    }
}
