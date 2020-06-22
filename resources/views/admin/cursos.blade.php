@extends('homeAdmin')

@section('tables')

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

@endsection