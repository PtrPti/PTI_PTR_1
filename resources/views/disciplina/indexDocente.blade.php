@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <a class="back" href="{{ route ('homeDocente') }}">« Voltar</a>
    <h1><?php echo $cadeira->nome ?></h1>
</div>

<div class="container-flex">
    <div class="flex-left">
        <button type="button" class="addBtn" onclick="$('.bg-modal').slideToggle();">Criar Projeto</button>
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

<div class="bg-modal">
    <div class="model-content">
        <div class="close" onclick="closeForm()" >x</div>
        <h4>Novo Projeto</h4>
        
        <form id="add_project" action="{{ route('projetoPost', 'indexDcoente') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="cadeira_id" value="{{ $cadeira->id }}" required>
            <input type="text" placeholder="Nome do Projeto" name="nome">
            <input type="number" placeholder="Número de elementos" name="n_elem">
            <input type="text" class="date" placeholder="Data de entrega" name="datafim" required>

            <button type="submit">Adicionar</button>
        </form>
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

    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });
</script>

@endsection