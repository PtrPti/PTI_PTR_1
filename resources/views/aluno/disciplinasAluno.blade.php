@extends('layouts.app_aluno')

@section('content')

<div class="pagDisciplina">
    <div class="navDisciplina">
        <button class="pagInicia_btn"> Página inicial </button>
        <button class="avaliacao_btn"> Avaliação </button>
        <button class="horarios_btn"> Horários </button>
        <button class="trabalho_btn"> Trabalhos </buttons>
    </div>

    <div class="disciplinasAluno">

        <div class="infDisciplina">
        </div>
        
        <div class="avalDisciplina">
        </div>

        <div class="horariosDisciplinas">
        </div>
        
        <div class="projetosDisciplina">
            <div class="todos_projetos">
                @foreach ($cadeiraProjetos as $projeto)
                <div>
                    <h4 style="text-transform: capitalize;">{{$projeto->nome}}</h4>          
                    <b>Data de entrega: </b>{{$projeto->data_fim}}  
                    <br>                
                    <button type="button" class="showGrupos" onclick="ShowGrupos({{$projeto->id}})"> Ver projeto </button>
                </div>
                @endforeach  
            </div>

            <div class="inforcao_projeto">
        
            </div>
        </div>
    </div>
</div>