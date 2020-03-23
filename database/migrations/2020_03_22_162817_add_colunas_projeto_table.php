<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunasProjetoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->integer('n_max_elementos');
            $table->date('data_fim');
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
           
            
            $table->dropColumn('data_fim');
            $table->dropColumn('n_max_elementos');
        });
    }
}
