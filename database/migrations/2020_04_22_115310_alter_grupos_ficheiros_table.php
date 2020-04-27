<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGruposFicheirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->dropForeign(['pasta_id']);
            $table->dropColumn('pasta_id');
        });

        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->integer('pasta_id')->unsigned()->nullable();
            $table->string('link')->default('')->change();
        });

        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            $table->foreign('pasta_id')->references('id')->on('grupos_ficheiros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupos_ficheiros', function (Blueprint $table) {
            //
        });
    }
}
