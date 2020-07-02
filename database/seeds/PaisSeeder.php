<?php

use Illuminate\Database\Seeder;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paises = [
            ['nome' => 'Portugal', 'codigo' => 'PT'],
        ];

        DB::table('paises')->insert($paises);
    }
}
