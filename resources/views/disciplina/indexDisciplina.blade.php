@extends('layouts.app_novo')

@section('content')

<div class="row-title">
    <h2>{{$disciplina->nome}}</h2>
    @if (Auth::user()->isProfessor())
        <button id="add" type="button" class="btn-title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i>{{ __('change.criar_adicionar') }} </button>
        <ul class="dropdown-menu" aria-labelledby="add">
            <li><i class="fas fa-clipboard-list"></i><a role="button" data-toggle="modal" data-target="#addProject"> {{ __('change.projeto') }} </a></li>        
            <!-- <li><i class="fas fa-file"> </i> <a id="addFile" role="button" data-toggle="modal" data-target="#addFile"> Carregar Ficheiro </a></li> -->
        </ul>

        
    @endif
</div>

<div class="nav-tabs">
    <div class="tab tab-active" id="tab1" onclick="changeTab(1)">{{ __('change.paginaInicial') }}</div>
    <div class="tab" id="tab2" onclick="changeTab(2)"> {{ __('change.avaliacao') }} </div>
    <div class="tab" id="tab3" onclick="changeTab(3)"> {{ __('change.horarios') }} </div>
    @if (Auth::user()->isProfessor())
        <div class="tab" id="tab4" onclick="changeTab(4)"> {{ __('change.alunos') }} </div>
    @endif
</div>

<div class="tab-container" id="tab-1">
    @include('disciplina.pagInicial')
</div>

<div class="tab-container" id="tab-2">    
    @include('disciplina.avaliacao')
</div>

<div class="tab-container" id="tab-3">
{{ __('change.construcao') }}
</div>

@if (Auth::user()->isProfessor())

    <div class="tab-container" id="tab-4">

    @include('disciplina.listaAlunos')
    
    </div>
@endif

<div class="tab-container forum" id="tab-5">
    @include('disciplina.forum')
</div>

<div class="tab-container forumMensagens" id="tab-6">
    @include('disciplina.forumMensagens')
</div>

<div class="tab-container" id="tab-7">
    @include('disciplina.grupos')
</div>

@if (Auth::user()->isProfessor())
    <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectLabel">{{ __('change.criarPorjeto') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route ('criarProjeto', <?php echo $disciplina->id ?>) }}" id="project">
                        {{csrf_field()}}
                        <input type="hidden" name="cadeira_id" value="{{ $disciplina->id }}" required>
                        <input type="hidden" name="form" value="addProject">
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="text" name="nome" class="display-input" id="nome">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="nome" class="labelTextModal">{{ __('change.nomeDoProjeto') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="n_elem" class="display-input" id="n_elem" min="1" max="10" value="0" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="n_elem" class="labelTextModal">{{ __('change.numDeElementos') }}</label>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="datainicio" id="datainicio">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="datainicio" class="labelTextModal">{{ __('change.dataInicio') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="datafim" id="datafim">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="datafim" class="labelTextModal">{{ __('change.dataEntrega') }}</label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                                <button type="button" class="btn btn-primary" onclick="Save('project', '/criarProjeto')">{{ __('change.criar') }}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('change.fechar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function () {
        changeTab(<?php echo $active_tab ?>);
    });



    function verAvaliacaoDisciplina(id_cadeira, mensagem) {
        $.ajax({
            url: '/verAvaliacaoDisciplina',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: { 'id_cadeira': id_cadeira },
            success: function (data) {
                $("#tab-2").html(data.html);
                changeTab(2, 'block', mensagem);
            }
        });
    }


    function EditEvaluation(id) {
        $("#editEvaluationForm #avaliacao_id").val(id);
        }

    function EraiseEvaluation(id) {
        $("#eraiseEvaluationForm #avaliacao_id_eraise").val(id);
        }


    

 
   
</script>

@endsection