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
        $this->call(PerfisTableSeeder::class);
        $this->call(GrausAcademicosTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(CursosTableSeeder::class);
    }
}
