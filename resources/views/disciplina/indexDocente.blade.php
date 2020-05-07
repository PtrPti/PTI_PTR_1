@extends('layouts.app_docente')

@section('content')

<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 

    <div class="flex-left">
        <a class="back" href="{{ route ('homeDocente') }}">« Voltar</a>

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
            @if ($projeto->ficheiro != "")
                <p><span class="projetosLabels">Enunciado: </span><a href="{{ url('/download', $projeto->ficheiro) }}">{{ explode("_", $projeto->ficheiro, 2)[1] }}</a></p>
            @endif
            <button type="button" class="showGrupos" onclick="ShowGrupos({{$projeto->id}})">Ver grupos <i class="fa fa-users"></i></button>
        </div>
        @endforeach
    </div>

    <div class="flex-right">
        <h2><?php echo $cadeira->nome ?></h2>
        <div class="flex-right-container">
        </div>
    </div>
    
</div>

<div id="projetoModal" class="model-content">
    <div class="close" onclick="closeForm()" >x</div>
    <h4>Novo Projeto</h4>
    
    <form id="add_project" action="{{ route('projetoPost', 'indexDocente') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="cadeira_id" value="{{ $cadeira->id }}" required>
        <input type="text" placeholder="Nome do Projeto" name="nome">
        <input type="number" placeholder="Número de elementos" name="n_elem">
        <input type="text" class="date" placeholder="Data de Inicio" name="datainicio" required>
        <input type="text" class="date" placeholder="Data de entrega" name="datafim">

        <button type="submit">Criar</button>
    </form>
</div>

<div id="fileModal" class="model-content">
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


<div id="grupoNModal" class="model-content">
    <div class="close" onclick="closeForm()" >x</div>
    <h4>Nº de grupos</h4>
        <input type="number" placeholder="Número de elementos" name="n_grupos" min="1" max="100" value="1">
        <button type="button" onclick="AddMultGrupo('{{$projeto->id}}')">Criar</button>
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
                $(".flex-right-container").empty();
                $(".flex-right-container").append(data.html);
            }
        });
    }

    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });

    function CriarProjeto() {
        $('#projetoModal').show();
    }

    function AddFile(title) {
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    function closeForm() {
        $('.model-content').hide();
    }
</script>

@endsection