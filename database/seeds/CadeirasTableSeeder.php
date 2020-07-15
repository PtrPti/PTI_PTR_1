<?php

use Illuminate\Database\Seeder;

class CadeirasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cadeiras = [
            ['nome' => 'Arquiteturas de Computadores', 'codigo' => '1', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Elementos de Matemática I', 'codigo' => '2', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Produção de Documentos Técnicos', 'codigo' => '3', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Programação I', 'codigo' => '4', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Programação II', 'codigo' => '5', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Elementos de Matemática II', 'codigo' => '6', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Introdução às Probabilidades e Estatísticas', 'codigo' => '7', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Introdução às Tecnologias Web', 'codigo' => '8', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Redes de Computadores', 'codigo' => '9', 'ano' => '1', 'active' => '1'],
            ['nome' => 'Base de Dados', 'codigo' => '10', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Fundamentos e Técnicas de Visualização', 'codigo' => '11', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Interação com Computadores', 'codigo' => '12', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Programação Centrada em Objetos', 'codigo' => '13', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Sistemas Operativos', 'codigo' => '14', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Análise e Desenho de Software', 'codigo' => '15', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Aplicações Distribuídas', 'codigo' => '16', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Aplicações e Serviços na Web', 'codigo' => '17', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Conceção de Produto', 'codigo' => '18', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Sistemas Inteligentes', 'codigo' => '19', 'ano' => '2', 'active' => '1'],
            ['nome' => 'Construção de Sistemas de Software', 'codigo' => '20', 'ano' => '3', 'active' => '1'],
            ['nome' => 'Planeamento e Gestão de Projeto', 'codigo' => '21', 'ano' => '3', 'active' => '1'],
            ['nome' => 'Projeto de Tecnologias de Redes', 'codigo' => '22', 'ano' => '3', 'active' => '1'],
            ['nome' => 'Projeto de Tecnologias de Informação', 'codigo' => '23', 'ano' => '3', 'active' => '1']
        ];

        DB::table('cadeiras')->insert($cadeiras);
    }
}
