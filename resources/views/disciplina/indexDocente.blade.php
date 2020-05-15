@extends('layouts.app_docente')

@section('content')

<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 

    <div class="flex-left">
        <div class="nav_icons_back">
            <a href="{{ route('homeDocente') }}"><div><img src="{{ asset('images/home_icon.png') }}"> Home </div></a>
            <a><div><img src="{{ asset('images/disciplinas_icon.png') }}"> Disciplinas </div></a>
            <a><div><img src="{{ asset('images/projetos_icon.png') }}"> Projetos </div></a>
        </div>

        <button id="btnAdd" ><img src="{{ asset('images/plus_docente.png') }}" width="23"><span>Criar/Adicionar</span></button>
        <div id="dropAdd">
            <span onclick="AddFile('Enunciado')">Enunciado <i class="fas fa-file-import"></i> </span>
            <span onclick="CriarProjeto()">Projeto <i class="fas fa-chalkboard-teacher"></i> </span>
        </div>
            
        @foreach ($projetos as $projeto)
        <div class="projeto">
            <h4>{{ $projeto->nome }}</h4>
            <p><span class="projetosLabels">Data de entrega: </span><span>{{ date('l jS F Y H:i', strtotime($projeto->data_fim)) }}</span></p>
            @if ($projeto->ficheiro != "")
                <p><span class="projetosLabels">Enunciado: </span><a href="{{ url('/download', $projeto->ficheiro) }}">{{ explode("_", $projeto->ficheiro, 2)[1] }}</a></p>
            @endif
            <button type="button" id="show_{{$projeto->id}}" class="showGrupos" onclick="ShowGrupos({{$projeto->id}})">Ver grupos <i class="fa fa-users"></i></button>
        </div>
        @endforeach
    </div>

    <div class="flex-right">
        <h2><?php echo $cadeira->nome ?></h2>
        <div class="nav_disciplina">
            <div class="disciplina_tab" id="tab1" onclick="ShowPagInicial()">Página Inicial </div>
            <div class="disciplina_tab" id="tab2" onclick="ShowAvaliacao()"> Avaliação </div>
            <div class="disciplina_tab" id="tab3" onclick="ShowHorario()"> Horários </div>
        </div>

        <div class="flex-right-container">
            @include('disciplina.pagInicial')
            @include('disciplina.avaliacao')
            @include('disciplina.horario')
            @include('disciplina.grupos')
            @include('disciplina.forum')
            @include('disciplina.forumMensagens')
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
                <button type="button" onclick="AddMultGrupo(<?php if (isset($projeto)) echo $projeto->id ?>)">Criar</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        TabActive('<?php echo $active_tab ?>');

        @if(!empty($funcParams))
            ShowPage(<?php echo $funcParams[0] ?>, '<?php echo $funcParams[1] ?>', '<?php echo $funcParams[2] ?>', '<?php if(!empty($openForm)) {echo $openForm;} ?>');
        @endif
    })

    function ShowGrupos(id) {
        $.ajax({
            url: '/showGrupos',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $(".disciplina_tab").removeClass('active');
                $(".discpContainer").css('display', 'none');
                $("#grupos").html(data.html);
                $("#grupos").css('display', 'block');
                $("#show_" + id).attr("onclick","HideGrupos(" + id + ")");
                $("#show_" + id).html("Esconder grupos <i class='fa fa-users'></i>");
            }
        });
    }

    function HideGrupos(id) {
        $(".discpContainer").css('display', 'none');
        $("#pagInicial").css('display', 'block');
        $("#tab1").addClass('active');
        $("#show_" + id).attr("onclick","ShowGrupos(" + id + ")");
        $("#show_" + id).html("Ver grupos <i class='fa fa-users'></i>");
    }

    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });

    function CriarProjeto() {
        $('.model-content').hide();
        $('#projetoModal').show();
    }

    function AddFile(title) {
        $('.model-content').hide();
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    function closeForm() {
        $('.model-content').hide();
    }

    $(document).mouseup(function(e) {
        var container = $("#dropAdd");
        if ((!container.is(e.target) && container.has(e.target).length === 0)){
            container.hide();
        }
        else {
            container.show();
        }
    });

    $("#dropAdd").hide();

    $("#btnAdd").click(function(){
        $("#dropAdd").show();
    }); 
</script>

@endsection