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
            ['curso_id' => '1', 'cadeira_id' => '1'],
            ['curso_id' => '1', 'cadeira_id' => '2'],
            ['curso_id' => '1', 'cadeira_id' => '3'],
            ['curso_id' => '1', 'cadeira_id' => '4'],
            ['curso_id' => '1', 'cadeira_id' => '5'],
            ['curso_id' => '1', 'cadeira_id' => '6'],
            ['curso_id' => '1', 'cadeira_id' => '7'],
            ['curso_id' => '1', 'cadeira_id' => '8'],
            ['curso_id' => '1', 'cadeira_id' => '9'],
            ['curso_id' => '1', 'cadeira_id' => '10'],
            ['curso_id' => '1', 'cadeira_id' => '11'],
            ['curso_id' => '1', 'cadeira_id' => '12'],
            ['curso_id' => '1', 'cadeira_id' => '13'],
            ['curso_id' => '1', 'cadeira_id' => '14'],
            ['curso_id' => '1', 'cadeira_id' => '15'],
            ['curso_id' => '1', 'cadeira_id' => '16'],
            ['curso_id' => '1', 'cadeira_id' => '17'],
            ['curso_id' => '1', 'cadeira_id' => '18'],
            ['curso_id' => '1', 'cadeira_id' => '19'],
            ['curso_id' => '1', 'cadeira_id' => '20'],
            ['curso_id' => '1', 'cadeira_id' => '21'],
            ['curso_id' => '1', 'cadeira_id' => '22'],
            ['curso_id' => '1', 'cadeira_id' => '23'],
        ];

        DB::table('cursos_cadeiras')->insert($cursos_cadeiras);
    }
}
