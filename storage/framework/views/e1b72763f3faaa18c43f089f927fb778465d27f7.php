<!-- <div class="discpContainer" id="grupos">
    <div class="addBtn-row">
        <button type="button" class="addBtn" onclick="AddGrupo(<?php if (isset($projeto_id)) echo $projeto_id ?>)">Adicionar grupo</button>
        <button type="button" class="addBtn" onclick="AddMultGrupModal()">Adicionar múltiplos grupos</button>
    </div>

    <table class="tableGrupos" id="tableShowGrupos">
        <?php if(isset($grupos)): ?>
            <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="grupo_<?php echo e($grupo->id); ?>">
                <td>
                    <?php if($grupo->total_membros == 0): ?>
                        <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                    <?php endif; ?>
                </td>
                <td>Grupo <?php echo e($grupo->numero); ?></td>
                <td><?php echo e($grupo->total_membros); ?>/<?php echo $max_elementos ?></td>
                <td><?php echo e($grupo->elementos); ?></td>
            <tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </table>
</div> -->

<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <b>Nome projeto</b>
</div>

<div class="split-left">
    <!-- <button type="button" data-toggle="dropdown" id="add" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="fas fa-plus"></i> Adicionar
    </button>
    <ul class="dropdown-menu" aria-labelledby="add">
        <li><i class="fas fa-folder"></i> Pasta</li>
        <li><i class="fas fa-file"> </i> Carregar Ficheiro</li>
        <li><i class="fas fa-folder"></i> Carregar Pasta</li>
        <li><i class="fas fa-link"></i> Site/Link</li>
        <li><i class="fas fa-tasks"></i> Tarefa/Subtarefa</li>
        <li><i class="fas fa-sticky-note"> </i>Nota</li>
    </ul> -->

    <ul class="grupoFiles">
        <li>
            <i class="fas fa-folder-open"></i><a href="#" class="no-link">Pasta 1</a>
            <ul>
                <li><i class="fas fa-file"></i><a href="#">Ficheiro 1</a></li>
            </ul>
        </li>
        <li>
            <i class="fas fa-folder-open"></i><a href="#" class="no-link">Pasta 2</a>
            <ul>
                <li><i class="fas fa-file"></i><a href="#">Ficheiro 2</a></li>
            </ul>
        </li>
        <li><i class="fas fa-file"></i><a href="#">Ficheiro</a></li>
        <li><i class="fas fa-file"></i><a href="#">Ficheiro</a></li>
        <li><i class="fas fa-file"></i><a href="#">Ficheiro</a></li>
        <li><i class="fas fa-link"></i><a href="#">Link</a></li>
        <li><i class="fas fa-link"></i><a href="#">Link</a></li>
        <li><i class="fas fa-sticky-note"></i><a href="#" class="no-link">Nota</a></li>
        <li><i class="fas fa-sticky-note"></i><a href="#" class="no-link">Nota</a></li>
    </ul>
</div>

<div class="split-right">
    <div class="row-add">
        <?php if(isset($projeto_id)): ?>
            <button type="button" class="add-button" onclick="AddGrupo(<?php echo $projeto_id ?>, 1)"><i class="fas fa-plus"></i> Adicionar grupo </button>
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
                            <!-- <form method="post" action="#"> -->
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="projeto_id" value="<?php echo e($projeto_id); ?>" required>
                                <div class="row group">
                                    <div class="col-md-12">
                                        <input type="number" placeholder="Número de elementos" name="n_grupos" min="1" max="100" value="1" class="display-input" id="n_grupos">
                                        <span class="highlight"></span>
                                        <span class="bar"></span>
                                        <label for="email" class="labelTextModal">Nº de grupos</label>
                                    </div>
                                </div>
                                <div class="row row-btn">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" onclick="AddMultGrupo(<?php if (isset($projeto)) echo $projeto->id ?>, $('input[name=n_grupos]').val())">Criar</button>
                                        <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <table class="tableForum">
        <?php if(isset($grupos)): ?>
            <tr>
                <th colspan="4">Grupos Inscritos: <?php echo e(sizeof($grupos)); ?></th>
            </tr>
            <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="grupo_<?php echo e($grupo->id); ?>">
                <td>
                    <?php if($grupo->total_membros == 0): ?>
                        <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                    <?php endif; ?>
                </td>
                <td><a href="<?php echo e(route('GrupoDocente', $grupo->id)); ?>">Grupo <?php echo e($grupo->numero); ?></a></td>
                <td><?php echo e($grupo->total_membros); ?>/<?php echo $max_elementos ?></td>
                <td><?php echo e($grupo->elementos); ?></td>
            <tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </table>
</div>

<script>
    function AddGrupo(id, grupos) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'grupos': grupos},
            success: function(data) {
                for(var i = 0; i < data.length; i++) {
                    $("#tableShowGrupos").append("<tr id='grupo_" + data[i][2] + "'><td><i class='fas fa-trash-alt' onclick='DeleteGroup(" + data[i][2] + ")'></i></td><td>Grupo " + data[i][0] + "</td><td>0/" + data[i][1] + "</td><td>-</td></tr>");
                }
            }
        });
    }

    // function AddMultGrupo(id, ) {
    //     $.ajax({
    //         url: '/addGrupo',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: 'success',
    //         data: {'id': id, 'grupos': $('input[name=n_grupos]').val()},
    //         success: function(data) {
    //             for(var i = 0; i < data.length; i++) {
    //                 $("#tableShowGrupos").append("<tr id='grupo_" + data[i][2] + "'><td><i class='fas fa-trash-alt' onclick='DeleteGroup(" + data[i][2] + ")'></i></td><td>Grupo " + data[i][0] + "</td><td>0/" + data[i][1] + "</td><td>-</td></tr>");
    //             }
    //         }
    //     });
    // }

    function DeleteGroup(id) {
        if(confirm('Tem a certeza que deseja apagar o grupo ?')) {
            $.ajax({
                url: 'deleteGrupo',
                type: 'POST',
                dataType: 'json',
                data: {'id': id, '_token': '<?php echo e(csrf_token()); ?>'},
                success: function(data) {
                    $("#grupo_" + id).remove();
                }
            });
        }
    }
</script>