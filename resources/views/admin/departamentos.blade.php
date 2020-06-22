@extends('homeAdmin')

@section('tables')

<div class="row-title title-admin">
    <h2>Departamentos</h2>
</div>

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

{{$departamentos->links()}}

@endsection