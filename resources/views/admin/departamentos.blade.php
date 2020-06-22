@extends('homeAdmin')

@section('tables')

<table class="adminTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Código</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departamentos as $departamento) 
            <tr>
                <td>{{$departamento->nome}}</td>
                <td>{{$departamento->cod_departamentos}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection