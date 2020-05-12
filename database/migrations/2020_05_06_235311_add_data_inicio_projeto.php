<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataInicioProjeto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dateTime('data_fim')->nullable()->change();
            $table->string('estado')->nullable()->change();
            $table->dateTime('data_inicio')->nullable();
            $table->boolean('inscricoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropColumn('data_inicio');
            $table->dropColumn('inscricoes');
        });
    }
}
