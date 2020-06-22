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
            ['nome' => 'Arquiteturas de Computadores', 'cod_cadeiras' => '1', 'ano' => '1', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Elementos de Matemática I', 'cod_cadeiras' => '2', 'ano' => '1', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Produção de Documentos Técnicos', 'cod_cadeiras' => '3', 'ano' => '1', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Programação I', 'cod_cadeiras' => '4', 'ano' => '1', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Programação II', 'cod_cadeiras' => '5', 'ano' => '1', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Elementos de Matemática II', 'cod_cadeiras' => '6', 'ano' => '1', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Introdução às Probabilidades e Estatísticas', 'cod_cadeiras' => '7', 'ano' => '1', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Introdução às Tecnologias Web', 'cod_cadeiras' => '8', 'ano' => '1', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Redes de Computadores', 'cod_cadeiras' => '9', 'ano' => '1', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Base de Dados', 'cod_cadeiras' => '10', 'ano' => '2', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Fundamentos e Técnincas de Visualização', 'cod_cadeiras' => '11', 'ano' => '2', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Interação com Computadores', 'cod_cadeiras' => '12', 'ano' => '2', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Programação Centrada em Objetos', 'cod_cadeiras' => '13', 'ano' => '2', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Sistemas Operativos', 'cod_cadeiras' => '14', 'ano' => '2', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Análise e Desenho de Software', 'cod_cadeiras' => '15', 'ano' => '2', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Aplicações Distribuídas', 'cod_cadeiras' => '16', 'ano' => '2', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Aplicações e Serviços na Web', 'cod_cadeiras' => '17', 'ano' => '2', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Conceção de Produto', 'cod_cadeiras' => '18', 'ano' => '2', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Sistemas Inteligentes', 'cod_cadeiras' => '19', 'ano' => '2', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Construção de Sistemas de Software', 'cod_cadeiras' => '20', 'ano' => '3', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Planeamento e Gestão de Projeto', 'cod_cadeiras' => '21', 'ano' => '3', 'semestre_id' => '1', 'active' => '1'],
            ['nome' => 'Projeto de Tecnologias de Redes', 'cod_cadeiras' => '22', 'ano' => '3', 'semestre_id' => '2', 'active' => '1'],
            ['nome' => 'Projeto de Tecnologias de Informação', 'cod_cadeiras' => '23', 'ano' => '3', 'semestre_id' => '2', 'active' => '1']
        ];

        DB::table('cadeiras')->insert($cadeiras);
    }
}
