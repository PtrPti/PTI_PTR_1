@extends('homeAdmin')

@section('tables')

<table class="adminTable">
    <thead>
        <tr>
            <th>Ano letivo</th>
            <th>Mês inicio</th>
            <th>Ano inicio</th>
            <th>Mês fim</th>
            <th>Ano fim</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anosLetivos as $ano) 
            <tr>
                <td>{{$ano->ano}}</td>
                <td>{{$ano->mes_inicio}}</td>
                <td>{{$ano->ano_inicio}}</td>
                <td>{{$ano->mes_fim}}</td>
                <td>{{$ano->ano_fim}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection