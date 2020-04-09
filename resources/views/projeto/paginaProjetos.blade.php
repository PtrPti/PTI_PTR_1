@extends('layouts.app_docente')

@section('content')

<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 

    <div class="flex-left">
        <a class="back" href="{{ route ('homeDocente', 'tab2') }}">« Voltar</a>

        <li class="open-dropdown has-dropdown">
            <a id="open-dropdown">Adicionar <i class="fa fa-caret-down"></i></a>
            <ul class="dropdown">
                <li class="dropdown-item">
                    <button type="button" onclick="#">Tarefa</button>
                </li>
                <li class="dropdown-item">
                    <button type="button" onclick="#">Ficheiro</button>
                </li>
            </ul>
        </li>
        
        <div class="flex-left-links">
            <img src="{{ asset('images/pdf.png') }}" class="flex-left-icon" />
            <a href="#" class="tasks_proj" >Ver Enunciado</a>
        </div>
               
        <div class="flex-left-links">
            <img src="{{ asset('images/excel.png') }}" class="flex-left-icon" /> 
            <a href="#" class="tasks_proj">Abrir Excel </a>
        </div>

        <div class="flex-left-links">
            <img src="{{ asset('images/note.png') }}" class="flex-left-icon" /> 
            <a href="#" class="tasks_proj" id="openNotepad">Bloco de Notas </a>
        </div>
    </div>

    <div class="flex-right">
        <div class="flex-right-header">
            <h2>{{ $projeto->nome }}</h2>
            <h3>Disciplina: <a href="{{ route('indexDisciplinaDocente', $cadeira->id) }}">{{ $cadeira->nome }}</a></h3>
        </div>
        <div class="flex-right-container">
            <h4>Grupos inscritos:  {{ $gruposcount }}</h4>
            <table class="tableGrupos">
                @foreach ($grupos as $grupo)
                <tr>
                    <td>Grupo {{$grupo->numero}}</td>
                    <td>0/{{$projeto->n_max_elementos}}</td>
                    <td>-</td>
                <tr>
                @endforeach
            </table>
        </div>
    </div>    
</div>

<script>
    $("#openNotepad").click(function() {
        $(this).before("<textarea></textarea>");    
    });
</script>

@endsection