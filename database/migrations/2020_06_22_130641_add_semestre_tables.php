<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSemestreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         Schema::table('cadeiras', function (Blueprint $table) {
//             $table->integer('semestre_id')->unsigned();
//         });

//         Schema::table('cadeiras', function (Blueprint $table) {
//             $table->foreign('semestre_id')->references('id')->on('semestre')->onDelete('cascade');
//         });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//         Schema::table('cadeiras', function (Blueprint $table) {
//             $table->dropForeign(['semestre_id']);
//             $table->dropColumn('semestre_id');
//         });
   }
 }
