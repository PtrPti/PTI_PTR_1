@extends('layouts.app_aluno')

@section('content')

<div>
    <div class="divDisciplinas ">
        <h4>Disciplinas</h4>
        <div class="disciplina">
            @foreach ($cadeiras as $cadeira)
            <div>
                {{$cadeira->nome}}  
                <br>                
                <a href="{{ route('pagDisciplina') }}"> Entrar Disciplina</a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="projetos">
        <a href="{{ route('pagProjeto') }}"> Entrar Projeto </a>
    </div>
</div>
@endsection
