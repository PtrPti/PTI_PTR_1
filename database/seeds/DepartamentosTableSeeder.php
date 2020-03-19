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
            ['nome' => 'Informática', 'cod_departamentos' => '1'],
            ['nome' => 'Matemática', 'cod_departamentos' => '2'],
        ];

        DB::table('departamentos')->insert($departamentos);
    }
}
