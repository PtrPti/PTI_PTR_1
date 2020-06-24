<?php

use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departamentos = [
            ['nome' => 'Informática', 'codigo' => '1'],
            ['nome' => 'Matemática', 'codigo' => '2'],
        ];

        DB::table('departamentos')->insert($departamentos);
    }
}
