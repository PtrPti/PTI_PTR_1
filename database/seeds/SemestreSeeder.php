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
            ['semestre' => '1º', 'dia_inicio' => '1', 'mes_inicio' => '9', 'dia_fim' => '17', 'mes_fim' => '2'],
            ['semestre' => '2º', 'dia_inicio' => '18', 'mes_inicio' => '2', 'dia_fim' => '30', 'mes_fim' => '6'],
        ];

        DB::table('semestre')->insert($semestre);
    }
}
