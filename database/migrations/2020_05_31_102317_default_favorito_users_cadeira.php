<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultFavoritoUsersCadeira extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->boolean('favorito')->default(FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_cadeiras', function (Blueprint $table) {
            $table->dropColumn(['favorito']);
        });
    }
}
