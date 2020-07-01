<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCodigoCadeiras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadeiras', function (Blueprint $table) {
            $table->dropColumn('cod_cadeiras');
        });
        Schema::table('cadeiras', function (Blueprint $table) {
            $table->string('codigo', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadeiras', function (Blueprint $table) {
            //
        });
    }
}
