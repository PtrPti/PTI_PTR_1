@extends('layouts.app_aluno')

@section('content')

<div class="homeAluno">
    
    <div class="divDisciplinas ">
        <h4 style="margin-left:15px;">Disciplinas</h4>
        <div class="disciplina">
            @foreach ($cadeiras as $cadeira)
            <a href="{{ route('pagDisciplina', ['cadeira_id' => $cadeira->id]) }}"> 
                <div> 
                    {{$cadeira->nome}} 
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="divGrupos">
        <h4 style="margin-left:15px;">Projetos</h4>
        <div class="grupo">
            @if (count($projetos) == 0)
                <p>Não está inscrito em nenhum projeto/grupo</p>                                   
            @else
                @foreach ($projetos as $proj)
                <a href="{{ route('pagProjeto', ['id' => $proj->id]) }}">
                    <div>
                        {{$proj->projeto}} | Grupo Nº{{$proj->numero}}<br>
                        <small>{{$proj->cadeiras}}</small>
                    </div>
                </a>
                @endforeach 
            @endif
        </div>
    </div>

</div>