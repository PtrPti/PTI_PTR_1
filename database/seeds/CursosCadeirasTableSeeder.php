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
            ['curso_id' => '1', 'cadeira_id' => '1', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '2', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '3', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '4', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '5', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '6', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '7', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '8', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '9', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '10', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '11', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '12', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '13', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '14', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '15', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '16', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '17', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '18', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '19', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '20', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '21', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '22', 'ano_letivo_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '23', 'ano_letivo_id' => '1'],
        ];

        DB::table('cursos_cadeiras')->insert($cursos_cadeiras);
    }
}
