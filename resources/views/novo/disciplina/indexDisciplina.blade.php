@extends('layouts.app_novo')

@section('content')

<div class="row-title">
    <h2>{{$disciplina->nome}}</h2>
    @if (Auth::user()->isProfessor())
        <button id="add" type="button" class="btn-title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i> Criar/Adicionar</button>
        <ul class="dropdown-menu" aria-labelledby="add">
            <li><i class="fas fa-clipboard-list"></i><a role="button" data-toggle="modal" data-target="#addProject"> Projeto </a></li>        
            <!-- <li><i class="fas fa-file"> </i> <a id="addFile" role="button" data-toggle="modal" data-target="#addFile"> Carregar Ficheiro </a></li> -->
        </ul>
    @endif
</div>

<div class="nav-tabs">
    <div class="tab tab-active" id="tab1" onclick="changeTab(1)">Página Inicial </div>
    <div class="tab" id="tab2" onclick="changeTab(2)"> Avaliação </div>
    <div class="tab" id="tab3" onclick="changeTab(3)"> Horários </div>
    @if (Auth::user()->isProfessor())
        <div class="tab" id="tab4" onclick="changeTab(4)"> Alunos </div>
    @endif
</div>

<div class="tab-container" id="tab-1">
    @include('novo.disciplina.pagInicial')
</div>

<div class="tab-container" id="tab-2">
    Avaliação
</div>

<div class="tab-container" id="tab-3">
    Horário
</div>

@if (Auth::user()->isProfessor())
    <div class="tab-container" id="tab-4">
    @include('novo.disciplina.listaAlunos')
    </div>
@endif

<div class="tab-container forum" id="tab-5">
    @include('novo.disciplina.forum')
</div>

<div class="tab-container forumMensagens" id="tab-6">
    @include('novo.disciplina.forumMensagens')
</div>

<div class="tab-container" id="tab-7">
    @include('novo.disciplina.grupos')
</div>

@if (Auth::user()->isProfessor())
    <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectLabel">Criar projeto</h5>
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
                                <label for="nome" class="labelTextModal">Nome do projeto</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="n_elem" class="display-input" id="n_elem" min="1" max="10" value="0" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="n_elem" class="labelTextModal">Nº de elementos</label>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="datainicio" id="datainicio">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="datainicio" class="labelTextModal">Data de início</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="datafim" id="datafim">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="datafim" class="labelTextModal">Data de entrega</label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                                <button type="button" class="btn btn-primary" onclick="Save('project', '/criarProjeto')">Criar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
</script>

@endsection