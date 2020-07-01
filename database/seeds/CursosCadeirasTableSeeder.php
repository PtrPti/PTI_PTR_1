<?php

use Illuminate\Database\Seeder;

class CursosCadeirasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cursos_cadeiras = [
            ['curso_id' => '1', 'cadeira_id' => '1', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '2', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '3', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '4', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '5', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '6', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '7', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '8', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '9', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '10', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '11', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '12', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '13', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '14', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '15', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '16', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '17', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '18', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '19', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '20', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '21', 'semestre_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '22', 'semestre_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '23', 'semestre_id' => '2'],
        ];

        DB::table('cursos_cadeiras')->insert($cursos_cadeiras);
    }
}
