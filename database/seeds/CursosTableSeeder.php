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
            ['nome' => 'Tecnologias de Informação'],
            ['nome' => 'Engenharia Informática']
        ];

        DB::table('cursos')->insert($cursos);
    }
}
