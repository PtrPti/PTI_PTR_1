@extends('layouts.app_docente')

@section('content')

<div class="nav_icons">
    <a class="back" href="{{ route ('homeDocente') }}">« Voltar</a>
    <h1><?php echo $cadeira->nome ?></h1>
</div>

<div class="container-flex">
    <div class="flex-left">        
        <li class="open-dropdown has-dropdown">
          <a id="open-dropdown">Criar/Adicionar <i class="fa fa-caret-down"></i></a>
          <ul class="dropdown">
            <li class="dropdown-item">
                <button type="button" onclick="CriarProjeto()">Projeto</button>
            </li>
            <li class="dropdown-item">
                <button type="button" onclick="AddFile('Adicionar Enunciado')">Enunciado</button>
            </li>
          </ul>
        </li>
        @foreach ($projetos as $projeto)
        <div class="projeto">
            <h4>{{ $projeto->nome }}</h4>
            <!-- <p><span class="projetosLabels">Data de entrega: </span><span>{{ $projeto->data_fim }}</span></p> --><!-- ->format('l jS F Y H:i')*@ -->
            <p><span class="projetosLabels">Data de entrega: </span><span>{{ $projeto->data_fim }}</span></p>
            <p><span class="projetosLabels">Enunciado: </span><a href="{{ url('/download', $projeto->ficheiro) }}">{{ explode("_", $projeto->ficheiro, 2)[1] }}</a></p>
            <button type="button" class="showGrupos" onclick="ShowGrupos({{$projeto->id}})">Ver grupos <i class="fa fa-users"></i></button>
        </div>
        @endforeach
    </div>

    <div class="flex-right">
        
    </div>
    
</div>

<div class="bg-modal projetoModal">
    <div class="model-content">
        <div class="close" onclick="closeForm()" >x</div>
        <h4>Novo Projeto</h4>
        
        <form id="add_project" action="{{ route('projetoPost', 'indexDocente') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="cadeira_id" value="{{ $cadeira->id }}" required>
            <input type="text" placeholder="Nome do Projeto" name="nome">
            <input type="number" placeholder="Número de elementos" name="n_elem">
            <input type="text" class="date" placeholder="Data de entrega" name="datafim" required>

            <button type="submit">Criar</button>
        </form>
    </div>
</div>

<div class="bg-modal fileModal">
    <div class="model-content">
        <div class="close" onclick="closeForm()" >x</div>
        <h4 id="titleModal"></h4>
        
        <form id="add_file" action="{{ route('uploadFile') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="cadeira_id" value="{{ $cadeira->id }}" required>
            <input type="file" placeholder="Nome do Projeto" name="file">

            <select class="form-control" name="projeto_id" id="projeto_id" required>
                <option value="">-- Selecionar --</option>
                @foreach ($projetos as $projeto)
                    <option value="{{$projeto->id}}">{{$projeto->nome}}</option>
                @endForeach
            </select>

            <button type="submit">Criar</button>
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

    function CriarProjeto() {
        $('.projetoModal').slideToggle('fast', function() { 
            if ($(this).is(':visible')) $(this).css('display','flex');
         });
    }

    function AddFile(title) {
        $('.fileModal').slideToggle('fast', function() { 
            if ($(this).is(':visible')) $(this).css('display','flex');
         });
        $('#titleModal').text(title);
    }
</script>

@endsection