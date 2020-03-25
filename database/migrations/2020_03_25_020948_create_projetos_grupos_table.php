<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
        Schema::table('grupos', function (Blueprint $table) {
            $table->integer('projeto_id')->unsigned();
            $table->integer('numero')->nullable()->change();
        });

        Schema::table('grupos', function (Blueprint $table) {
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign(['projeto_id']);
            $table->dropColumn('projeto_id');
        });
    }
}
