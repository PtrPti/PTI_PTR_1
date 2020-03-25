@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <a class="back" href="{{ route ('homeDocente') }}">« Voltar</a>
    <h1><?php echo $cadeira->nome ?></h1>
</div>

<div class="container-flex">
    <div class="flex-left">
        <button type="button" class="btnAdd">Criar Projeto</button>
        @foreach ($projetos as $projeto)
        <div class="projeto">
            <h4>{{ $projeto->nome }}</h4>
            <span>Data de entrega: {{ $projeto->data_fim->format('d-m-Y H:i') }}</span>
            <button type="button" onclick="ShowGrupos({{$projeto->id}})">Ver grupos</button>
        </div>
        @endforeach
    </div>

    <div class="flex-right">
        
    </div>
</div>

<script>
    function ShowGrupos(id) {
        $.ajax({
            url: '/showGrupos',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $(".flex-right").empty();
                $(".flex-right").append(data.html);
            }
        });
    }
</script>

@endsection