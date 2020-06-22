<?php

use Illuminate\Database\Seeder;

class PerfisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfis = [
            ['nome' => 'Aluno'],
            ['nome' => 'Professor'],
            ['nome' => 'Administrador'],
        ];

        DB::table('perfis')->insert($perfis);
    }
}
