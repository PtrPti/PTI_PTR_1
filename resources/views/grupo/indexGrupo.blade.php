@extends('layouts.app_novo')

@section('content')

<div class="row-title breadcrums">
    <h3><a href="{{ route('disciplina', ['id' => $disciplina->id]) }}">{{ $disciplina->nome }}</a> » {{ $projeto->nome }}</h3>
</div>

<div id='membros'>
    <button type="button" data-toggle="dropdown" id="membros" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-users"></i> {{ __('change.membros') }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="membros">
        @foreach($membros as $membro)
            <li>{{$membro->nome}}</li>
        @endforeach
    </ul>
    <span><strong>{{ __('change.dataFinal') }}:</strong> {{ $projeto->data_fim }}</span>
</div>

<div class="p_grupo">
    <div class="split-left">
        @if (Auth::user()->isAluno())
            <button type="button" data-toggle="dropdown" id="add" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-plus"></i> {{ __('change.adicionar') }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="add">
                <a class="addToGrupo" role="button" data-toggle="modal" data-target="#addToGrupo" data-id="1"><li><i class="fas fa-tasks"></i>{{ __('change.criarTarefaSubTarefa') }}</li></a>
                <a class="addToGrupo" role="button" data-toggle="modal" data-target="#addToGrupo" data-id="2"><li><i class="fas fa-folder"></i>{{ __('change.criarPasta') }}</li></a>
                <a class="addToGrupo" role="button" data-toggle="modal" data-target="#addToGrupo" data-id="3"><li><i class="fas fa-file"> </i>{{ __('change.carregar_ficheiro') }}</li></a>
                <a class="addToGrupo" role="button" data-toggle="modal" data-target="#addToGrupo" data-id="4"><li><i class="fas fa-link"></i>{{ __('change.adicionarSiteLink') }}</li></a>
                <a class="addToGrupo" role="button" data-toggle="modal" data-target="#addToGrupo" data-id="5"><li><i class="fas fa-sticky-note"></i>{{ __('change.criarNota') }}</li></a>
            </ul>
        @endif

        <ul class="grupoFiles">
            @foreach ($ficheiros as $ficheiro)
                @if ($ficheiro->is_folder)
                    <li class="folder">
                        <i class="fas fa-times-circle" onclick="remover('grupo',{{ $ficheiro->id }}, {{ $grupo->id }})"></i> <i class="fas fa-folder"></i><a href="#" class="no-link">{{ $ficheiro->nome }}</a>
                        <ul class="subFiles">
                        @foreach ($subFicheiros as $subficheiro)
                            @if ($subficheiro->pasta_id === $ficheiro->id)
                                @if(is_null($subficheiro->link) and is_null($subficheiro->notas))
                                    <i class="fas fa-times-circle" onclick="remover('grupo',{{ $subficheiro->id }}, {{ $grupo->id }})"></i><li><i class="fas fa-file"></i><a href="{{ url('/download', ['folder' => 'grupo', 'filename' => $subficheiro->nome]) }}">{{ explode("_", $ficheiro->nome, 2)[1] }}</a></li>
                                @elseif(!is_null($subficheiro->link))
                                    @if(is_null($subficheiro->nome))
                                        <i class="fas fa-times-circle" onclick="remover('grupo',{{ $subficheiro->id }}, {{ $grupo->id }})"></i><li><i class="fas fa-link"></i><a href="{{$subficheiro->link}}" target="_blank">{{ str_limit($subficheiro->link, $limit = 25, $end = '...') }}</a></li>
                                    @else 
                                        <i class="fas fa-times-circle" onclick="remover('grupo',{{ $subficheiro->id }}, {{ $grupo->id }})"></i><li><i class="fas fa-link"></i><a href="{{$subficheiro->link}}" target="_blank">{{ str_limit($subficheiro->nome, $limit = 25, $end = '...') }}</a></li>
                                    @endif
                                @else
                                    <li><i class="fas fa-times-circle" onclick="remover('grupo',{{ $subficheiro->id }}, {{ $grupo->id }})"></i><i class="fas fa-sticky-note"></i><a href="#" class="no-link" onclick="infoNota('grupo',{{$subficheiro->id}})">{{$subficheiro->nome}}</a></li>
                                @endif
                            @else
                                <li><i class="fas fa-sticky-note"></i><a href="#" class="no-link" onclick="infoNota('grupo',{{$subficheiro->id}})">{{$subficheiro->nome}}</a></li>
                            @endif
                        @endforeach
                        </ul>
                    </li>
                @elseif ( !$ficheiro->is_folder and is_null($ficheiro->pasta_id))
                    @if(is_null($ficheiro->link) and is_null($ficheiro->notas))
                        <li><i class="fas fa-file"></i><a href="{{ url('/download', ['folder' => 'grupo', 'filename' => $ficheiro->nome]) }}">{{ explode("_", $ficheiro->nome, 2)[1] }}</a></li>
                    @elseif(!is_null($ficheiro->link))
                        @if(!is_null($ficheiro->nome))
                            <li><i class="fas fa-link"></i><a href="{{$ficheiro->link}}" target="_blank">{{ str_limit($ficheiro->link, $limit = 25, $end = '...') }}</a></li>
                        @else 
                            <li><i class="fas fa-link"></i><a href="{{$ficheiro->link}}" target="_blank">{{$ficheiro->nome}}</a></li>
                        @endif
                    @else
                        <li><i class="fas fa-sticky-note"></i><a href="#" class="no-link" onclick="infoNota('grupo',{{$ficheiro->id}})">{{$ficheiro->nome}}</a></li>
                    @endif               
                @endif
            @endforeach
        </ul>

        @if (Auth::user()->isAluno())
            <div class="modal fade" id="addToGrupo" tabindex="-1" role="dialog" aria-labelledby="addToGrupoLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addToGrupoLabel">{{ __('change.criar_adicionar') }} <span id="titleAdd"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('addFileGrupo') }}" id="grupoAdd" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="projeto_id" value="{{ $projeto->id }}">
                                <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                <div class="row group">
                                    <div class="col-md-12">
                                        <select name="typeAdd" id="typeAdd" class="select-input">
                                            <option value="1">{{ __('change.tarefaSubTarefa') }}</option>
                                            <option value="2">{{ __('change.pasta') }}</option>
                                            <option value="3">{{ __('change.ficheiro') }}</option>
                                            <option value="4">{{ __('change.siteLink') }}</option>
                                            <option value="5">{{ __('change.nota') }}</option>
                                        </select>
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="typeAdd" class="labelTextModal">{{ __('change.criar_adicionar') }}</label>
                                    </div>
                                </div>
                                
                                <div id="modalG-1" class="modal-tab"><!-- Tarefa -->
                                    <div class="row group">
                                        <div class="col-md-6">
                                            <input type="text" name="nomeTarefa" class="display-input" id="nomeTarefa">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="nomeTarefa" class="labelTextModal">{{ __('change.nomeTarefa') }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="membro" id="membro" class="select-input">
                                                <option value="">--{{ __('change.selecionarPessoa') }}--</option>
                                                @foreach($membros as $membro)
                                                    <option value="{{$membro->id}}">{{$membro->nome}}</option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="membro" class="labelTextModal">{{ __('change.atribuirA') }}</label>
                                        </div>
                                    </div>
                                    <div class="row group">
                                        <div class="col-md-6">
                                            <select name="tarefaAssociada" id="tarefaAssociada" class="select-input">
                                                <option value="">--{{ __('change.selecionarTarefa') }}--</option>
                                                @foreach($tarefasNaoFeitas as $tarefa)
                                                    @if($tarefa->tarefa_id == null)
                                                        <option value="{{$tarefa->id}}">{{$tarefa->nome}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="mensagem" class="labelTextModal">{{ __('change.associarATarefa') }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="display-input" name="prazo" id="prazo">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="mensagem" class="labelTextModal">{{ __('change.dataFimPrevista') }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-btn">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" onclick="Save('grupoAdd', '/createTarefa')" style="display: inline-block !important">{{ __('change.criar') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">{{ __('change.fechar') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalG-2" class="modal-tab"><!-- Pasta -->
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <input type="text" name="nomePasta" class="display-input" id="nomePasta">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="nomePasta" class="labelTextModal">{{ __('change.nomePasta') }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-btn">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" onclick="Save('grupoAdd', '/createPasta')" style="display: inline-block !important">{{ __('change.criar') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">{{ __('change.fechar') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalG-3" class="modal-tab"><!-- Ficheiro -->
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <select name="filePasta" id="filePasta" class="select-input">
                                                <option value="">--{{ __('change.selecionarPasta') }}--</option>
                                                @foreach($pastasSelect as $pasta)
                                                    <option value="{{$pasta->id}}">{{$pasta->nome}}</option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="filePasta" class="labelTextModal">{{ __('change.pasta') }}</label>
                                        </div>
                                    </div>
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <input type="file" id="grupoFile" name="grupoFile">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="grupoFile" class="labelTextModal">{{ __('change.ficheiro') }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-btn">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" style="display: inline-block !important">{{ __('change.criar') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">{{ __('change.fechar') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalG-4" class="modal-tab"><!-- Link -->
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <select name="linkPasta" id="linkPasta" class="select-input">
                                                <option value="">--{{ __('change.selecionarPasta') }}--</option>
                                                @foreach($pastasSelect as $pasta)
                                                    <option value="{{$pasta->id}}">{{$pasta->nome}}</option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="linkPasta" class="labelTextModal">{{ __('change.pasta') }}</label>
                                        </div>
                                    </div>
                                    <div class="row group">
                                        <div class="col-md-6">
                                            <input type="text" class="display-input" id="nomeLink" name="nomeLink">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="nomeLink" class="labelTextModal">{{ __('change.nome') }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="display-input" id="url" name="url">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="url" class="labelTextModal">URL</label>
                                        </div>
                                    </div>
                                    <div class="row row-btn">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" onclick="Save('grupoAdd', '/addLinkGrupo')" style="display: inline-block !important">{{ __('change.criar') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">{{ __('change.fechar') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalG-5" class="modal-tab"><!-- Nota -->
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <select name="notaPasta" id="notaPasta" class="select-input">
                                                <option value="">--{{ __('change.selecionarPasta') }}--</option>
                                                @foreach($pastasSelect as $pasta)
                                                    <option value="{{$pasta->id}}">{{$pasta->nome}}</option>
                                                @endforeach
                                            </select>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="notaPasta" class="labelTextModal">{{ __('change.pasta') }}</label>
                                        </div>
                                    </div>
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <input type="text" class="display-input" id="nomeNota" name="nomeNota">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="nomeNota" class="labelTextModal">{{ __('change.titulo') }}</label>
                                        </div>
                                    </div>
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <textarea name="notaTexto" cols="63" rows="3" class="area-input" maxlength="4000" id="notaTexto"></textarea>
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="notaTexto" class="labelAreaModal">{{ __('change.texto') }}</label>
                                        </div>
                                    </div>
                                    <div class="row row-btn">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" onclick="Save('grupoAdd', '/addNotaGrupo')" style="display: inline-block !important">{{ __('change.criar') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">{{ __('change.fechar') }}</button>
                                        </div>
                                    </div>         
                                </div>               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="split-right">
        <div class="nav-tabs">
            <div class="tab tab-active" id="tab1" onclick="changeTab(1)">{{ __('change.tarefas') }}</div>
            <div class="tab" id="tab2" onclick="changeTab(2)">Feedbacks</div>
            <div class="tab" id="tab4" onclick="changeTab(4)">Avaliação</div>
        </div>

        <div class="tab-container" id="tab-1">
            @include('grupo.tarefas')
        </div>

        <div class="tab-container" id="tab-2">
            @include('grupo.feedback')
        </div>

        <div class="tab-container" id="tab-3">
            <!-- é preenchido por ajax no feedback -->
        </div>

        <div class="tab-container" id="tab-4">
            @include('grupo.informacoes')
        </div>        
    </div>
</div>

<i class="far fa-calendar-alt fa-3x calendarBtn" onclick="ShowCalendar()"></i>
<div id='calendarContainer'>
    <div id='external-events'>
        <h4>Elementos do grupo</h4>
        <div id='external-events-list'>
            @foreach ($membros as $ug)                
                @if (Auth::user()->getUserId() == $ug->id)
                    <div class='fc-event draggable'>{{ $ug->nome }}</div>
                @else
                    <div class='fc-event undraggable'>{{ $ug->nome }}</div>
                @endif
            @endforeach
        </div>
    </div>

    <div id='calendar'></div>

    <div style='clear:both'></div>
</div>

<div id="notaa">
    <!-- view nota -->
    @include('grupo.nota')
</div>

<script>
    $(document).ready(function () {
        changeTab(<?php echo $active_tab ?>);

        $(".addToGrupo").click(function(){ // Click to only happen on announce links
            $('.modal-tab').css('display', 'none');
            $("#typeAdd").val($(this).data('id'));
            $("#modalG-" + $(this).data('id')).css('display', 'block');
            $("#typeAdd").addClass('used');
        });
 
        $('#typeAdd').change(function() {
            $('.modal-tab').css('display', 'none');
            $("#modalG-" + $(this).val()).css('display', 'block');
        });

        $(".folder>a").click(function() { // Click to only happen on announce links
            if($(this).prev().hasClass('fa-folder')) {
                $($(this)).next().css('display', 'block');
                $($(this)).prev().removeClass('fa-folder');
                $($(this)).prev().addClass('fa-folder-open');
            }
            else {
                $($(this)).next().css('display', 'none');
                $($(this)).prev().removeClass('fa-folder-open');
                $($(this)).prev().addClass('fa-folder');
            }
        });

        
    });

    function infoNota(tipo,id){
            $.ajax({
                url: '/infoNota',
                type: 'GET',
                dataType: 'json',
                success: 'success',
                data : {'tipo': tipo, 'id':id},
                success: function(data){
                    $('#notaa').html(data.html);
                    $('#notaa').show();
                }
            })
        }

    function remover(tipo,id,grupoId){
        $.ajax({
            url: '/remover',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data : {'tipo': tipo, 'id':id, 'grupoId': grupoId},
            success: function(data){
                var msg = "<span class='gritter-text'>" + data.msg + "</span>";

                AddGritter(data.title, msg, 'success');

                window.location.href = data.redirect;
            }
        })
    }
</script>
@endsection