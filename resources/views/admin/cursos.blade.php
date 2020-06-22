@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Cursos</h2>
</div>

<table class="adminTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
            <th>Departamento</th>
            <th>Ativo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cursos as $curso) 
            <tr>
                <td>{{$curso->nome}}</td>
                <td>{{$curso->codigo}}</td>
                <td>{{$curso->departamento}}</td>
                <td>{{$curso->active}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{$cursos->links()}}

@endsection