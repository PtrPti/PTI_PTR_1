<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkProjetosFicheiros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projetos_ficheiros', function (Blueprint $table) {
            $table->string('link')->nullable()->default(null);
            $table->string('nome')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projetos_ficheiros', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
}
