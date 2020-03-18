<?php

use Illuminate\Database\Seeder;

class GrausAcademicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $graus_academicos = [
            ['nome' => '9º ano'],
            ['nome' => '12º ano'],
            ['nome' => 'Licenciatura'],
        ];

        DB::table('graus_academicos')->insert($graus_academicos);
    }
}
