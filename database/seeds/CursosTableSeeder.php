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
            ['nome' => 'Tecnologias de Informação', 'departamento_id' => '1'],
            ['nome' => 'Engenharia Informática', 'departamento_id' => '1']
        ];

        DB::table('cursos')->insert($cursos);
    }
}
