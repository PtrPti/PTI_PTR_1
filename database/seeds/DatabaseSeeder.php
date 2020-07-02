<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AnoLetivoSeeder::class);
        $this->call(SemestreSeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(DistritoSeeder::class);
        $this->call(PerfisTableSeeder::class);
        $this->call(GrausAcademicosTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(CursosTableSeeder::class);
        $this->call(CadeirasTableSeeder::class);
        $this->call(CursosCadeirasTableSeeder::class);
    }
}
