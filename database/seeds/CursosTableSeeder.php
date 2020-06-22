<?php

use Illuminate\Database\Seeder;

class CursosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cursos = [
            ['nome' => 'Tecnologias de Informação', 'departamento_id' => '1', 'active' => '1', 'codigo' => 'LTI'],
            ['nome' => 'Engenharia Informática', 'departamento_id' => '1', 'active' => '1', 'codigo' => 'LEI']
        ];

        DB::table('cursos')->insert($cursos);
    }
}
