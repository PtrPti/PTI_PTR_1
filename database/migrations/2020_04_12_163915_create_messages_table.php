<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->boolean('id_read');
            $table->timestamps();

        });


                Schema::table('messages', function (Blueprint $table) {
                    $table->integer('from')->unsigned();
                    $table->integer('to')->unsigned();
                });

                Schema::table('messages', function (Blueprint $table) {
                    $table->foreign('from')->references('id')->on('users')->onDelete('cascade');
                    $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
                });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
