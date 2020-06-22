@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Disciplinas</h2>
</div>

<table class="adminTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
            <th>Ano</th>
            <th>Semestre</th>
            <th>Curso</th>
            <th>Ano letivo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cadeiras as $cadeira) 
            <tr>
                <td>{{$cadeira->nome}}</td>
                <td>{{$cadeira->cod_cadeiras}}</td>
                <td>{{$cadeira->ano}}</td>
                <td>{{$cadeira->semestre}}</td>
                <td>{{$cadeira->curso}}</td>
                <td>{{$cadeira->ano_letivo}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{$cadeiras->links()}}

@endsection