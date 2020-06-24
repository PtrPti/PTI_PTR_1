<?php

use Illuminate\Database\Seeder;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semestre = [
            ['semestre' => '1º', 'dia_inicio' => '9', 'mes_inicio' => '9', 'ano_inicio' => '2019', 'dia_fim' => '8', 'mes_fim' => '2', 'ano_fim' => '2020', 'ano_letivo_id' => '1'],
            ['semestre' => '2º', 'dia_inicio' => '22', 'mes_inicio' => '2', 'ano_inicio' => '2020', 'dia_fim' => '27', 'mes_fim' => '7', 'ano_fim' => '2020', 'ano_letivo_id' => '1'],
        ];

        DB::table('semestre')->insert($semestre);
    }
}
