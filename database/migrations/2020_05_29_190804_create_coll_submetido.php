<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollSubmetido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->boolean('submetido')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->dropColumn('submetido');
        });
    }
}
