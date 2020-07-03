<div class="back-links">
    
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <b><span class="breadcrum"></span></b> <?php if(isset($projeto)): ?><span> - Termina em: <?php echo e($projeto->data_fim); ?></span><?php endif; ?>
</div>

<div class="split-left">
    <h5>Ficheiros do projeto</h5>
    <?php if(Auth::user()->isProfessor()): ?>
        <button type="button" data-toggle="dropdown" id="add" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-plus"></i> <?php echo e(__('change.adicionar')); ?>

        </button>
        <ul class="dropdown-menu" aria-labelledby="add">
            <li><i class="fas fa-file"> </i><a class="addToProj" role="button" data-toggle="modal" data-target="#addToProj" data-id="1"><?php echo e(__('change.carregar_ficheiro')); ?></a></li>
            <li><i class="fas fa-link"></i><a class="addToProj" role="button" data-toggle="modal" data-target="#addToProj" data-id="2"><?php echo e(__('change.adicionarSiteLink')); ?></a></li>
        </ul>
    <?php endif; ?>

    <?php if(isset($projFicheiros)): ?>
        <ul class="grupoFiles">
            <?php $__currentLoopData = $projFicheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ficheiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_null($ficheiro->link)): ?>
                    <li><i class="fas fa-file"></i><a href="<?php echo e(url('/download', ['folder' => 'projeto', 'filename' => $ficheiro->nome])); ?>"><?php echo e(explode("_", $ficheiro->nome, 2)[1]); ?></a></li>
                <?php else: ?>
                    <?php if(is_null($ficheiro->nome)): ?>
                        <li><i class="fas fa-link"></i><a href="<?php echo e($ficheiro->link); ?>" target="_blank"><?php echo e(str_limit($ficheiro->link, $limit = 20, $end = '...')); ?></a></li>
                    <?php else: ?>
                        <li><i class="fas fa-link"></i><a href="<?php echo e($ficheiro->link); ?>" target="_blank"><?php echo e(str_limit($ficheiro->nome, $limit = 20, $end = '...')); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>

    <?php if(Auth::user()->isProfessor() && isset($projeto)): ?>
        <div class="modal fade" id="addToProj" tabindex="-1" role="dialog" aria-labelledby="addToProjLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addToProjLabel"><?php echo e(__('change.criar_adicionar')); ?> <span id="titleAdd"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php echo e(route('addFileProjeto')); ?>" id="projAdd" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="projeto_id" id="projeto_id" value="<?php echo e($projeto->id); ?>">
                            <input type="hidden" name="cadeira_id" value="<?php echo e($projeto->cadeira_id); ?>" required>
                            <div class="row group">
                                <div class="col-md-12">
                                    <select name="typeAdd" id="typeAdd" class="select-input">
                                        <option value="1"><?php echo e(__('change.ficheiro')); ?></option>
                                        <option value="2"><?php echo e(__('change.siteLink')); ?></option>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="typeAdd" class="labelTextModal"><?php echo e(__('change.criar_adicionar')); ?></label>
                                </div>
                            </div>
                            <div id="modalP-1" class="modal-tab"><!-- Ficheiro -->
                                <div class="row group">
                                    <div class="col-md-12">
                                        <input type="file" id="projetoFile" name="projetoFile">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="projetoFile" class="labelTextModal"><?php echo e(__('change.ficheiro')); ?></label>
                                    </div>
                                </div>
                                <div class="row row-btn">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" style="display: inline-block !important"><?php echo e(__('change.criar')); ?></button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important"><?php echo e(__('change.fechar')); ?></button>
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
                                        <button type="button" class="btn btn-primary" onclick="Save('projAdd', '/addLinkProjeto')" style="display: inline-block !important"><?php echo e(__('change.criar')); ?></button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important"><?php echo e(__('change.fechar')); ?></button>
                                    </div>
                                </div>
                            </div>                      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="split-right">
    <div class="row-add">
        <?php if(isset($projeto)): ?>
            <?php if($projeto->data_fim >= date('Y-m-d H:i:s')): ?>
                <?php if(Auth::user()->isProfessor()): ?>
                    <button type="button" class="add-button" onclick="AddGrupo(<?php echo $projeto->id ?>, 1)"><i class="fas fa-plus"></i> <?php echo e(__('change.adicionarGrupo')); ?> </button>
                    <button type="button" class="add-button" data-toggle="modal" data-target="#addGrupo"><i class="fas fa-plus"></i> <?php echo e(__('change.adicionarmGrupo')); ?></button>            

                    <div class="modal fade" id="addGrupo" tabindex="-1" role="dialog" aria-labelledby="addGrupo" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addGrupoLabel"><?php echo e(__('change.criarGrupos')); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="#" id="addMultGrupos">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="projeto_id" value="<?php echo e($projeto->id); ?>" required>
                                        <input type="hidden" name="cadeira_id" value="<?php echo e($projeto->cadeira_id); ?>" required>
                                        <input type="hidden" name="entrar" value="false">
                                        <div class="row group">
                                            <div class="col-md-12">
                                                <input type="number" name="n_grupos" min="1" max="10" value="0" class="display-input" id="n_grupos">
                                                <span class="highlight"></span>
                                                <span class="bar"></span>
                                                <label for="n_grupos" class="labelTextModal"><?php echo e(__('change.numGrupos')); ?></label>
                                            </div>
                                        </div>
                                        <div class="row row-btn">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary" onclick="Save('addMultGrupos', '/addGrupo')"><?php echo e(__('change.criar')); ?></button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if($pertenceGrupo == null): ?>
                        <button type="button" class="add-button" onclick="AddGrupo(<?php echo $projeto->id ?>, 1, true)"><i class="fas fa-plus"></i> <?php echo e(__('change.adicionarGrupo')); ?> </button>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <table class="tableForum">
        <?php if(Auth::user()->isProfessor()): ?>
            <?php if(isset($grupos)): ?>
                <tr>
                    <th colspan="4"><?php echo e(__('change.gruposInscritos')); ?>: <?php echo e(sizeof($grupos)); ?></th>
                </tr>
                <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="grupo_<?php echo e($grupo->id); ?>">
                    <td>
                        <?php if($grupo->total_membros == 0): ?>
                            <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                        <?php endif; ?>
                    </td>
                    <td><a href="<?php echo e(route('projeto', $grupo->id)); ?>"><?php echo e(__('change.grupo')); ?> <?php echo e($grupo->numero); ?></a></td>
                    <td><?php echo e($grupo->total_membros); ?>/<?php echo e($projeto->n_max_elementos); ?></td>
                    <td><?php echo e($grupo->elementos); ?></td>
                <tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if(isset($grupos)): ?>
                <tr>
                    <th><?php echo e(__('change.numeroDoGrupo')); ?></th>
                    <th><?php echo e(__('change.totalDeMembros')); ?></th>
                    <th colspan="2"><?php echo e(__('change.elementos')); ?></th>
                </tr>
                <?php $inGroup = False; ?>
                <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php if($pertenceGrupo != null && $grupo->id == $pertenceGrupo->grupo_id): ?>
                            <a href="<?php echo e(route('projeto', $grupo->id)); ?>"><?php echo e(__('change.grupo')); ?> <?php echo e($grupo->numero); ?></a>
                        <?php else: ?>
                        <?php echo e(__('change.grupo')); ?> <?php echo e($grupo->numero); ?>

                        <?php endif; ?>
                    </td>
                    <td><?php echo e($grupo->total_membros); ?> / <?php echo e($projeto->n_max_elementos); ?></td>
                    <td><?php echo e($grupo->elementos); ?></td>
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
                                    echo "<button type='button' class='buttun_group' onclick='addUser($grupo->id, $projeto->id)'>Entrar No Grupo</button>", csrf_field();
                                }
                            }            
                        ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endif; ?>
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
            data: {'projeto_id': id, 'n_grupos': grupos, 'entrar': entrar, 'cadeira_id': <?php if (isset($projeto))echo $projeto->cadeira_id ?>},
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