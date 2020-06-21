<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <b><span class="breadcrum"></span></b>
</div>

<div class="split-left">
    @if (Auth::user()->isProfessor())
        <button type="button" data-toggle="dropdown" id="add" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-plus"></i> Adicionar
        </button>
        <ul class="dropdown-menu" aria-labelledby="add">
            <li><i class="fas fa-file"> </i><a class="addToProj" role="button" data-toggle="modal" data-target="#addToProj" data-id="1">Carregar ficheiro</a></li>
            <li><i class="fas fa-link"></i><a class="addToProj" role="button" data-toggle="modal" data-target="#addToProj" data-id="2">Adicionar site/link</a></li>
        </ul>
    @endif

    @isset($projFicheiros)
        <ul class="grupoFiles">
            @foreach($projFicheiros as $ficheiro)
                @if(is_null($ficheiro->link))
                    <li><i class="fas fa-file"></i><a href="{{ url('/download', ['folder' => 'projeto', 'filename' => $ficheiro->nome]) }}">{{ explode("_", $ficheiro->nome, 2)[1] }}</a></li>
                @else
                    @if(is_null($ficheiro->nome))
                        <li><i class="fas fa-link"></i><a href="{{$ficheiro->link}}" target="_blank">{{ str_limit($ficheiro->link, $limit = 20, $end = '...') }}</a></li>
                    @else 
                        <li><i class="fas fa-link"></i><a href="{{$ficheiro->link}}" target="_blank">{{ str_limit($ficheiro->nome, $limit = 20, $end = '...') }}</a></li>
                    @endif
                @endif
            @endforeach
        </ul>
    @endisset

    @if (Auth::user()->isProfessor() && isset($projeto))
        <div class="modal fade" id="addToProj" tabindex="-1" role="dialog" aria-labelledby="addToProjLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addToProjLabel">Criar/Adicionar <span id="titleAdd"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('addFileProjeto') }}" id="projAdd" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="projeto_id" id="projeto_id" value="{{ $projeto->id }}">
                            <input type="hidden" name="cadeira_id" value="{{ $projeto->cadeira_id }}" required>
                            <div class="row group">
                                <div class="col-md-12">
                                    <select name="typeAdd" id="typeAdd" class="select-input">
                                        <option value="1">Ficheiro</option>
                                        <option value="2">Site/link</option>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="typeAdd" class="labelTextModal">Criar/adicionar</label>
                                </div>
                            </div>
                            <div id="modalP-1" class="modal-tab"><!-- Ficheiro -->
                                <div class="row group">
                                    <div class="col-md-12">
                                        <input type="file" id="projetoFile" name="projetoFile">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="projetoFile" class="labelTextModal">Ficheiro</label>
                                    </div>
                                </div>
                                <div class="row row-btn">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" style="display: inline-block !important">Criar</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important">Fechar</button>
                                    </div>
                                </div>
                            </div>
                            <div id="modalP-2" class="modal-tab"><!-- Link -->
                                <div class="row group">
                                    <div class="col-md-6">
                                        <input type="text" class="display-input" id="link" name="link">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="link" class="labelTextModal">Nome</label>
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
                                        <button type="button" class="btn btn-primary" onclick="Save('projAdd', '/addLinkProjeto')" style="display: inline-block !important">Criar</button>
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
</div>

<div class="split-right">
    <div class="row-add">
        @isset($projeto)
            @if (Auth::user()->isProfessor())
                <button type="button" class="add-button" onclick="AddGrupo(<?php echo $projeto->id ?>, 1)"><i class="fas fa-plus"></i> Adicionar grupo </button>
                <button type="button" class="add-button" data-toggle="modal" data-target="#addGrupo"><i class="fas fa-plus"></i> Adicionar múltiplos grupos</button>            

                <div class="modal fade" id="addGrupo" tabindex="-1" role="dialog" aria-labelledby="addGrupo" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addGrupoLabel">Criar grupos</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="#" id="addMultGrupos">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="projeto_id" value="{{ $projeto->id }}" required>
                                    <input type="hidden" name="cadeira_id" value="{{ $projeto->cadeira_id }}" required>
                                    <input type="hidden" name="entrar" value="false">
                                    <div class="row group">
                                        <div class="col-md-12">
                                            <input type="number" name="n_grupos" min="1" max="10" value="0" class="display-input" id="n_grupos">
                                            <span class="highlight"></span>
                                            <span class="bar"></span>
                                            <label for="n_grupos" class="labelTextModal">Nº de grupos</label>
                                        </div>
                                    </div>
                                    <div class="row row-btn">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" onclick="Save('addMultGrupos', '/addGrupo')">Criar</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @if ($pertenceGrupo == null)
                    <button type="button" class="add-button" onclick="AddGrupo(<?php echo $projeto->id ?>, 1, true)"><i class="fas fa-plus"></i> Adicionar grupo </button>
                @endif
            @endif
        @endisset
    </div>

    <table class="tableForum">
        @if (Auth::user()->isProfessor())
            @isset($grupos)
                <tr>
                    <th colspan="4">Grupos Inscritos: {{ sizeof($grupos) }}</th>
                </tr>
                @foreach ($grupos as $grupo)
                <tr id="grupo_{{$grupo->id}}">
                    <td>
                        @if ($grupo->total_membros == 0)
                            <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                        @endif
                    </td>
                    <td><a href="{{ route('projeto', $grupo->id) }}">Grupo {{$grupo->numero}}</a></td>
                    <td>{{$grupo->total_membros}}/{{$projeto->n_max_elementos}}</td>
                    <td>{{$grupo->elementos}}</td>
                <tr>
                @endforeach
            @endisset
        @else
            @isset($grupos)
                <tr>
                    <th>Número do grupo</th>
                    <th>Total de membros</th>
                    <th colspan="2">Elementos</th>
                </tr>
                <?php $inGroup = False; ?>
                @foreach ($grupos as $grupo)
                <tr>
                    <td>
                        @if($pertenceGrupo != null && $grupo->id == $pertenceGrupo->grupo_id)
                            <a href="{{ route('projeto', $grupo->id) }}">Grupo {{$grupo->numero}}</a>
                        @else
                            Grupo {{$grupo->numero}}
                        @endif
                    </td>
                    <td>{{$grupo->total_membros}} / {{$projeto->n_max_elementos}}</td>
                    <td>{{$grupo->elementos}}</td>
                    <td>            
                        <?php 
                            if ($pertenceGrupo != NULL) {
                                if($grupo->id == $pertenceGrupo->grupo_id) {
                                    echo "<button type='button' class='buttun_group' onclick='removeUser($grupo->id, $projeto->id)'>Sair do Grupo</button>", csrf_field();
                                }
                                else {
                                    echo " ";
                                }
                                $inGroup = True; 
                            }
                            else {
                                if($grupo->total_membros == $projeto->n_max_elementos) {
                                    echo "Fechado";
                                    $inGroup = True;
                                }
                                else {
                                    echo "<button type='button' class='buttun_group' onclick='addUser($grupo->id, $projeto->id)'>Entrar no Grupo</button>", csrf_field();
                                }
                            }            
                        ?>
                    </td>
                </tr>
                @endforeach
            @endisset
        @endif
    </table>
</div>

<script>
    $(document).ready(function () {
        $(".addToProj").click(function(){ // Click to only happen on announce links
            $('.modal-tab').css('display', 'none');
            $("#typeAdd").val($(this).data('id'));
            $("#modalP-" + $(this).data('id')).css('display', 'block');
            $("#typeAdd").addClass('used');
        });

        $('#typeAdd').change(function() {
            $('.modal-tab').css('display', 'none');
            $("#modalP-" + $(this).val()).css('display', 'block');
        });
    });
    function AddGrupo(id, grupos, entrar = false) {
        $.ajax({
            url: '/addGrupo',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'projeto_id': id, 'n_grupos': grupos, 'entrar': entrar},
            success: function(data) {
                ShowGrupos(id);
                AddGritter('Sucesso', '<span class="gritter-text">Grupo criado com sucesso</span>', 'success');
            }
        });
    }
    
    function DeleteGroup(id) {
        if (confirm('Tem a certeza que deseja apagar o grupo ?')) {
            $.ajax({
                url: '/deleteGrupo',
                type: 'POST',
                dataType: 'json',
                data: {'id': id},
                success: function (data) {
                    ShowGrupos(<?php if(isset($projeto)) { echo $projeto->id; } else { echo "''"; } ?>);
                    AddGritter('Sucesso', '<span class="gritter-text">Grupo apagado com sucesso</span>', 'success');
                }
            });
        }
    }

    function removeUser(grupo_id) {
        if (confirm('Tem a certeza que quer sair do grupo ?')) {
            $.ajax({
                url: '/removeUser',
                type: 'POST',
                dataType: 'json',
                data: {'grupo_id': grupo_id},
                success: function(data) {
                    ShowGrupos(<?php if(isset($projeto)) { echo $projeto->id; } else { echo "''"; } ?>);
                    AddGritter('Sucesso', '<span class="gritter-text">Saiu do grupo com sucesso</span>', 'success');
                }
            });
        }
    }
    
    function addUser(grupo_id) {
        $.ajax({
            url: '/addUser',
            type: 'POST',
            dataType: 'json',
            data: {'grupo_id': grupo_id},
            success: function(data) {
                ShowGrupos(<?php if(isset($projeto)) { echo $projeto->id; } else { echo "''"; } ?>);
                AddGritter('Sucesso', '<span class="gritter-text">Entrou no grupo com sucesso</span>', 'success');
            }
        });
    }
</script>