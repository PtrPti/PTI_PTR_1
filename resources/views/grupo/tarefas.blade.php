<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="{{$progresso}}" aria-valuemin="0"
        aria-valuemax="100" style="width:{{$progresso}}%">
        {{$progresso}} %
    </div>
</div>

<div class="search">
    @if(Session::has('search'))
        <script>
            $(document).ready(function() {
                $('input[type=search]').val('<?php echo Session::get('search') ?>');
            });
        </script>
    @endif
    @if(isset($grupo_id))
        <input type="search" class="search-input" placeholder="Pesquisar..." results="0" onsearch="OnSearch(this, {{$grupo_id}})">
        <i class="fas fa-search search-icon" onclick="Search({{$grupo_id}})"></i>
    @else
        <input type="search" class="search-input" placeholder="Pesquisar..." results="0" onsearch="OnSearch(this, {{$grupo->id}})">
        <i class="fas fa-search search-icon" onclick="Search({{$grupo->id}})"></i>
    @endif
</div>

<?php $tarefaPai = 0 ?>
@foreach($tarefasNaoFeitas as $tnf)
    @if($tnf->tarefa_id == null)
        @if ($tarefaPai > 0)
            </div>
        @endif
        <div class="divTarefa" id="{{$tnf->id}}">
            <div class='tarefa'>
                <i class="fas fa-chevron-circle-down open-subTask"></i>
                <label class="containerCheckbox">{{ $tnf->nome }}
                    <input type="hidden" value="">
                    @if (Auth::user()->isAluno())
                        <input class="input-pai" type="checkbox" @if (($tnf->estado)) checked @endif >
                    @else
                        <input class="input-pai" type="checkbox" disabled @if (($tnf->estado)) checked @endif >
                    @endif
                    <span class="checkmark"></span>
                </label>
                @if (Auth::user()->isAluno())
                    <i class="fas fa-edit" onclick="EditTarefa({{$tnf->id}})" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                    <i class="fas fa-plus-circle addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[1, {{$tnf->id}}]"></i>
                @else
                    <i class="fas fa-edit" onclick="EditTarefa({{$tnf->id}}, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                @endif

                <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                <div class="ficheirosTarefa">
                    @if(!is_null($tnf->atribuido))
                        <div class='nameUser'><span>{{ $tnf->atribuido }}</span></div>
                    @endif
                    <button type="button" data-toggle="dropdown" id='fich{{ $tnf->id }}' class='ficheirosbtn' aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-paperclip"></i><i class="fas fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="fich{{ $tnf->id }}">
                        @foreach($ficheirosTarefas as $fich)
                            @if($fich->tarefa_id === $tnf->id)
                                <?php $temFich = 1 ?>
                                @if(is_null($fich->link) and is_null($fich->notas))
                                    <li><i class="fas fa-file"></i><a href="{{ url('/download', ['folder' => 'grupo', 'filename' => $fich->nome]) }}">{{ explode("_", $fich->nome, 2)[1] }}</a></li>
                                @elseif(!is_null($fich->link))
                                    @if(!is_null($fich->nome))
                                        <li><i class="fas fa-link"></i><a href="{{$fich->link}}" target="_blank">{{ str_limit($fich->link, $limit = 25, $end = '...') }}</a></li>
                                    @else 
                                        <li><i class="fas fa-link"></i><a href="{{$fich->link}}" target="_blank">{{$fich->nome}}</a></li>
                                    @endif
                                @else
                                    <li><i class="fas fa-sticky-note"></i><a href="#" onclick="infoNota('tarefa',{{$fich->id}})" class="no-link">{{$fich->nome}}</a></li>
                                @endif
                           @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        <?php $tarefaPai++; ?>
    @else
            <div class="divSubTarefa {{$tnf->tarefa_id}}" id="{{$tnf->id}}">
                <i class="fas fa-edit" onclick="EditTarefa({{$tnf->id}})" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                <i class="fas fa-plus-circle addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[1, {{$tnf->id}}]"></i>
                <div class='tarefa'>
                    
                    <label class="containerCheckbox">{{ $tnf->nome }}
                        <input type="hidden" value="">
                        @if (Auth::user()->isAluno())
                            <input type="checkbox" @if (($tnf->estado)) checked @endif >
                        @else
                            <input type="checkbox" disabled @if (($tnf->estado)) checked @endif >
                        @endif
                        <span class="checkmark"></span>
                    </label>
                    @if (Auth::user()->isAluno())
                        
                    @else
                        <i class="fas fa-edit" onclick="EditTarefa({{$tnf->id}}, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                    @endif

                    <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                    <div class="ficheirosTarefa">
                        @if(!is_null($tnf->atribuido))
                            <div class='nameUser'><span>{{ $tnf->atribuido }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
            @if(Session::has('search'))
                <script>
                    $(document).ready(function() {
                        $('#{{$tnf->id}}').css('display', 'block');
                    });
                </script>
            @endif
    @endif
@endforeach
@if($tarefaPai > 0)
    </div>
@endif

<div id="tarefasFeitas">
    <?php $tarefaPai = 0 ?>
    @foreach($tarefasFeitas as $tf)
        @if($tf->tarefa_id == null)
            @if ($tarefaPai > 0)
                </div>
            @endif
            <div class="divTarefa" id="{{$tf->id}}">
                <div class='tarefa'>
                    <i class="fas fa-chevron-circle-down open-subTask"></i>
                    <label class="containerCheckbox">{{ $tf->nome }}
                        <input type="hidden" value="">
                        @if (Auth::user()->isAluno())
                            <input class="input-pai" type="checkbox" @if (($tf->estado)) checked @endif >
                        @else
                            <input class="input-pai" type="checkbox" disabled @if (($tf->estado)) checked @endif >
                        @endif
                        <span class="checkmark"></span>
                    </label>
                    <i class="fas fa-edit" onclick="EditTarefa({{$tf->id}}, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                    <div class="ficheirosTarefa">
                        @if(!is_null($tf->atribuido))
                            <div class='nameUser'><span>{{ $tf->atribuido }}</span></div>
                        @endif
                    </div>
                    <br >
                    <span class='duracao'>
                        <i class="far fa-clock"></i>
                        <?php   $datetime1 = new DateTime($tf->created_at);
                                $datetime2 = new DateTime($tf->finished_at);
                                $interval = date_diff($datetime1, $datetime2);
                                echo $interval->format('%a dias e %h horas'); ?>
                    </span>
                </div>
            <?php $tarefaPai++; ?>
        @else
                <div class="divSubTarefa {{$tf->tarefa_id}}" id="{{$tf->id}}">
                    <div class='tarefa'>
                        <label class="containerCheckbox">{{ $tf->nome }}
                            <input type="hidden" value="">
                            @if (Auth::user()->isAluno())
                                <input type="checkbox" @if (($tf->estado)) checked @endif >
                            @else
                                <input type="checkbox" disabled @if (($tf->estado)) checked @endif >
                            @endif
                            <span class="checkmark"></span>
                        </label>
                        <i class="fas fa-edit" onclick="EditTarefa({{$tf->id}}, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>

                        <div class="ficheirosTarefa">
                            @if(!is_null($tf->atribuido))
                                <div class='nameUser'><span>{{ $tf->atribuido }}</span></div>
                            @endif
                        </div>
                        <br >
                        <span class='duracao'>
                            <i class="far fa-clock"></i>
                            <?php   $datetime1 = new DateTime($tf->created_at);
                                $datetime2 = new DateTime($tf->finished_at);
                                $interval = date_diff($datetime1, $datetime2);
                                echo $interval->format('%a dias e %h horas'); ?>
                        </span>
                    </div>
                </div>
                @if(Session::has('search'))
                    <script>
                        $(document).ready(function() {
                            $('#{{$tf->id}}').css('display', 'block');
                        });
                    </script>
                @endif
        @endif
    @endforeach
    @if($tarefaPai > 0)
        </div>
    @endif
</div>

@if (Auth::user()->isAluno())
    <div class="modal fade" id="addToTarefa" tabindex="-1" role="dialog" aria-labelledby="addToTarefaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToTarefaLabel">Criar/Adicionar à tarefa <span id="titleAdd"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('addFileTarefa') }}" id="tarefaAdd" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="tarefa_id" id="tarefa_id" value="">
                        @if(isset($grupo_id))
                            <input type="hidden" name="grupo_id" id="grupo_id" value="{{$grupo_id}}">
                        @else
                            <input type="hidden" name="grupo_id" id="grupo_id" value="{{$grupo->id}}">
                        @endif
                        <div class="row group">
                            <div class="col-md-12">
                                <select name="typeAddTarefa" id="typeAddTarefa" class="select-input">
                                    <option value="1">Nota</option>
                                    <option value="2">Site/link</option>
                                    <option value="3">Ficheiro</option>
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="typeAddTarefa" class="labelTextModal">Criar/adicionar</label>
                            </div>
                        </div>
                        
                        <div id="modalT-1" class="modal-tab"><!-- Nota -->
                            <div class="row group">
                                <div class="col-md-12">
                                    <input type="text" class="display-input" id="nomeNota" name="nomeNota">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="nomeNota" class="labelTextModal">Título</label>
                                </div>
                            </div>
                            <div class="row group">
                                <div class="col-md-12">
                                    <textarea name="notaTexto" cols="63" rows="3" class="area-input" maxlength="4000" id="notaTexto"></textarea>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="notaTexto" class="labelAreaModal">Texto</label>
                                </div>
                            </div>
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" onclick="Save('tarefaAdd', '/addNotaTarefa')" style="display: inline-block !important">Criar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                                </div>
                            </div>
                        </div>
                        <div id="modalT-2" class="modal-tab"><!-- Link -->
                            <div class="row group">
                                <div class="col-md-6">
                                    <input type="text" class="display-input" id="nomeLink" name="nomeLink">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="nomeLink" class="labelTextModal">Nome</label>
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
                                    <button type="button" class="btn btn-primary" onclick="Save('tarefaAdd', '/addLinkTarefa')" style="display: inline-block !important">Criar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                                </div>
                            </div>
                        </div>
                        <div id="modalT-3" class="modal-tab"><!-- Ficheiro -->
                            <div class="row group">
                                <div class="col-md-12">
                                    <input type="file" id="grupoFile" name="grupoFile">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="grupoFile" class="labelTextModal">Ficheiro</label>
                                </div>
                            </div>
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" style="display: inline-block !important">Criar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                                </div>
                            </div>
                        </div>                     
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="modal fade" id="editTarefa" tabindex="-1" role="dialog" aria-labelledby="editTarefaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTarefaLabel">Criar/Adicionar <span id="titleAdd"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="editTarefaForm" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="tarefa_id" id="tarefa_id" value="">
                    @if(isset($grupo_id))
                        <input type="hidden" name="grupo_id" id="grupo_id" value="{{$grupo_id}}">
                    @else
                        <input type="hidden" name="grupo_id" id="grupo_id" value="{{$grupo->id}}">
                    @endif
                    
                    <!-- <div id="editT-1" class="modal-tab"> -->
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="text" name="nomeTarefa" class="display-input edit" id="nomeTarefa">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="nomeTarefa" class="labelTextModal">Nome da tarefa</label>
                            </div>
                            <div class="col-md-6">
                                <select name="membro" id="membro" class="select-input">
                                    <option value="" id="membro_0">--Selecionar pessoa--</option>
                                    @foreach($membros as $membro)
                                        <option value="{{$membro->id}}" id="membro_{{$membro->id}}">{{$membro->nome}}</option>
                                    @endforeach
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="membro" class="labelTextModal">Atribuir a</label>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-6">
                                <select name="tarefaAssociada" id="tarefaAssociada" class="select-input">
                                    <option value="" id="assoc_0">--Selecionar tarefa--</option>
                                    @foreach($tarefasNaoFeitas as $tarefa)
                                        @if($tarefa->tarefa_id == null)
                                            <option value="{{$tarefa->id}}" id="assoc_{{$tarefa->id}}">{{$tarefa->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="mensagem" class="labelTextModal">Associar à tarefa</label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="prazo" id="prazo">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="mensagem" class="labelTextModal">Data de fim prevista</label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" onclick="Save('editTarefaForm', '/editTarefaPost')" style="display: inline-block !important">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                            </div>
                        </div>
                    <!-- </div> -->
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".addToTarefa").click(function(){ // Click to only happen on announce links
            $('.modal-tab').css('display', 'none');
            $("#typeAddTarefa").val($(this).data('id')[0]);
            $("#modalT-" + $(this).data('id')[0]).css('display', 'block');
            $("#typeAddTarefa").addClass('used');
            $("#tarefa_id").val($(this).data('id')[1]);
        });

        $('#typeAddTarefa').change(function() {
            $('.modal-tab').css('display', 'none');
            $("#modalT-" + $(this).val()).css('display', 'block');
        });
    });

    $('.open-subTask').each(function(index, element) {
        if($('.' + $(element).parent().parent()[0].id).length == 0) {
            $(element).css('visibility', 'hidden');
        }
    });
    
    $('.open-subTask').click(function() {
        if($(this).hasClass('fa-chevron-circle-down')) {
            $(this).removeClass('fa-chevron-circle-down');
            $(this).addClass('fa-chevron-circle-up');
            $("." + $(this).parent().parent()[0].id).css('display', 'block');
        }
        else {
            $(this).removeClass('fa-chevron-circle-up');
            $(this).addClass('fa-chevron-circle-down');
            $("." + $(this).parent().parent()[0].id).css('display', 'none');
        }
    });

    //tarefa pai
    $(".divTarefa .input-pai").click(function() {
        var paiId = $(this).parent().parent().parent()[0].id;
        var checked = $(this).is(':checked');

        if (checked) {
            $('.' + paiId + ' input').prop('checked', true);
        } else {
            $('.' + paiId + ' input').prop('checked', false);
        }
        checkTarefa(paiId, checked, true);
    });

    //tarefa filho
    $(".divSubTarefa input").click(function() {
        var paiId = $(this).parent().parent().parent().parent()[0].id;
        var filhoId = $(this).parent().parent().parent()[0].id;
        var checked = $(this).is(':checked');

        if (checked) {
            $(this).prop('checked', true);
            if ($('.' + paiId).length == $('.' + paiId + ' input:checked').length) { //todas as filhas estao checked
                $('#' + paiId + ' input').prop('checked', true);
                checkTarefa(paiId, checked, true);
            }
            else {
                checkTarefa(filhoId, checked);
            }
        } else {
            $(this).prop('checked', false);
            if ($('.' + paiId).length == $('.' + paiId + ' input:checked').length + 1) { //todas as filhas estao checked menos uma (a que foi clickada)
                $('#' + paiId + ' .input-pai').prop('checked', false);
                checkTarefa(filhoId, checked, true, true); //o changePai vai a true pq ao tirar uma das filhas o pai também tem de ficar a false
            }
            else {
                checkTarefa(filhoId, checked);
            }
        }
    });

    function checkTarefa(id, val, update = false, changePai = false) {
        $.ajax({
            url: '/checkTarefa',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'val': val, 'update': update, 'changePai': changePai, "_token": "{{ csrf_token() }}", },
            success: function(data) {
                if (update) {
                    $("#tab-1").html(data.html);
                }
                else {
                    $('.progress-bar').css('width', data.progresso + '%');
                    $('.progress-bar').prop('aria-valuenow', data.progresso);
                    $('.progress-bar').text(data.progresso + '%');
                }
                AddGritter(data.title, '<span class="gritter-text">' + data.msg + '</span>', 'success');
            }
        });
    }

    function Search(id) {
        $.ajax({
            url: '/pesquisarTarefas',
            type: 'GET',
            data : {'grupo_id': id, 'search': $('input[type=search]').val(), 'clear': false},
            success: function(data){
                $("#tab-1").html(data.html);
            }
        });
    }

    function OnSearch(input, id) {
        var clear = input.value == "" ? true : false;
        $.ajax({
            url: '/pesquisarTarefas',
            type: 'GET',
            data : {'grupo_id': id, 'search': input.value, 'clear': clear},
            success: function(data){
                $("#tab-1").html(data.html);
            }
        });
    }

    function EditTarefa(id, disable = false) {
        $.ajax({
            url: '/editTarefa',
            type: 'GET',
            data : {'tarefa_id': id},
            success: function(data){
                $("#editTarefaForm #nomeTarefa").val(data.nome);
                $("#editTarefaForm #nomeTarefa").text(data.nome);
                $("#editTarefaForm #nomeTarefa").addClass('used');

                $("#membro_" + data.membro).prop('selected', true);
                if (data.membro != null) {
                    $("#editTarefaForm #membro").addClass('used');
                } 
                else {
                    $("#membro_0").prop('selected', true);
                }

                $("#assoc_" + data.tarefaAssoc).prop('selected', true);
                if (data.tarefaAssoc != null){                    
                    $("#editTarefaForm #tarefaAssociada").addClass('used');
                }
                else {
                    $("#assoc_0").prop('selected', true); ;
                }

                $("#editTarefaForm #prazo").val(data.prazo);
                if (data.prazo != null) $("#editTarefaForm #prazo").addClass('used');

                $("#editTarefaForm #tarefa_id").val(id);

                if (disable) {
                    $("#editTarefaForm input").prop('disabled', true);
                    $("#editTarefaForm select").prop('disabled', true);
                }
            }
        });
    }
</script>