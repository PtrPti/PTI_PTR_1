@extends('layouts.app_aluno')

@section('content')

<div class="homeAluno">
    <div class="divDisciplinas ">
        <h4 style="margin-left:15px;">Disciplinas</h4>
        <div class="disciplina">
            @foreach ($cadeiras as $cadeira)
            <div>
                {{$cadeira->nome}}  
                <br>                
                <a href="{{ route('pagDisciplina', ['cadeira_id' => $cadeira->id]) }}"> Entrar </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="divGrupos">
        <h4 style="margin-left:15px;">Projetos</h4>
        <div class="grupo">
            @foreach ($grupos as $grupo)
            <div>
                {{$grupo->nome}}  
                <br>                
                <a href="{{ route('pagProjeto')}}"> Entrar </a>
            </div>
            @endforeach
        </div>
    </div>
</div>