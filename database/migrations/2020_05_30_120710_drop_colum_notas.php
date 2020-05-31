<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumNotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropColumn('notas');
        });

        Schema::table('tarefas_ficheiros', function (Blueprint $table) {
            $table->string('notas')->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarefas_ficheiros', function (Blueprint $table) {
            $table->dropColumn('notas');
        });
    }
}
