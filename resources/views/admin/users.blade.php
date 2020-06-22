@extends('homeAdmin')

@section('tables')

<table class="adminTable">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Número</th>
            <th>Email</th>
            <th>Data de nascimento</th>
            <th>Departamento</th>
            <th>Curso</th>
            <th>Perfil</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user) 
            <tr>
                <td>{{$user->nome}}</td>
                <td>{{$user->numero}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->data_nascimento}}</td>
                <td>{{$user->departamento}}</td>
                <td>{{$user->curso}}</td>
                <td>{{$user->Perfil}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection