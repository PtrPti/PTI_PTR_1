@extends('homeAdmin')

@section('tables')

<table class="adminTable">
    <thead>
        <tr>
            <th>Semestre</th>
            <th>Dia inicio</th>
            <th>Mês inicio</th>
            <th>Dia fim</th>
            <th>Mês fim</th>
        </tr>
    </thead>
    <tbody>
        @foreach($semestres as $semestre) 
            <tr>
                <td>{{$semestre->semestre}}</td>
                <td>{{$semestre->dia_inicio}}</td>
                <td>{{$semestre->mes_inicio}}</td>
                <td>{{$semestre->dia_fim}}</td>
                <td>{{$semestre->mes_fim}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection