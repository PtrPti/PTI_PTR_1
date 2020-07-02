<?php

use Illuminate\Database\Seeder;

class DistritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distritos = [
            ['nome' => 'Aveiro', 'pais_id' => '1'],
            ['nome' => 'Beja', 'pais_id' => '1'],
            ['nome' => 'Braga', 'pais_id' => '1'],
            ['nome' => 'Bragança', 'pais_id' => '1'],
            ['nome' => 'Castelo Branco', 'pais_id' => '1'],
            ['nome' => 'Coimbra', 'pais_id' => '1'],
            ['nome' => 'Évora', 'pais_id' => '1'],
            ['nome' => 'Faro', 'pais_id' => '1'],
            ['nome' => 'Guarda', 'pais_id' => '1'],
            ['nome' => 'Leiria', 'pais_id' => '1'],
            ['nome' => 'Lisboa', 'pais_id' => '1'],
            ['nome' => 'Portalegre', 'pais_id' => '1'],
            ['nome' => 'Porto', 'pais_id' => '1'],
            ['nome' => 'Santarém', 'pais_id' => '1'],
            ['nome' => 'Setúbal', 'pais_id' => '1'],
            ['nome' => 'Viana do Castelo', 'pais_id' => '1'],
            ['nome' => 'Vila Real', 'pais_id' => '1'],
            ['nome' => 'Viseu', 'pais_id' => '1'],
        ];

        DB::table('distritos')->insert($distritos);
    }
}
