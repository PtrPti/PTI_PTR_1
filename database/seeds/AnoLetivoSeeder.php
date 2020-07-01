<?php

use Illuminate\Database\Seeder;

class AnoLetivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ano_letivo = [
            ['ano' => '19/20', 'dia_inicio' => '9', 'mes_inicio' => '9', 'ano_inicio' => '2019', 'dia_fim' => '27', 'mes_fim' => '7', 'ano_fim' => '2020'],
        ];

        DB::table('ano_letivo')->insert($ano_letivo);
    }
}
