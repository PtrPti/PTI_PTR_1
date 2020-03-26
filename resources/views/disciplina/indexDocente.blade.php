@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <a class="back" href="{{ route ('homeDocente') }}">« Voltar</a>
    <h1><?php echo $cadeira->nome ?></h1>
</div>

<div class="container-flex">
    <div class="flex-left">
        <button type="button" class="addBtn">Criar Projeto</button>
        @foreach ($projetos as $projeto)
        <div class="projeto">
            <h4>{{ $projeto->nome }}</h4>
            <p><span class="dueDate">Data de entrega: </span><span>{{ $projeto->data_fim->format('l jS F Y H:i') }}</span></p>
            <button type="button" class="showGrupos" onclick="ShowGrupos({{$projeto->id}})">Ver grupos <i class="fa fa-users"></i></button>
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