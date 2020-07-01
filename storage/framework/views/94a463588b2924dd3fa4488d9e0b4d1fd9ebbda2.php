<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($progresso); ?>" aria-valuemin="0"
        aria-valuemax="100" style="width:<?php echo e($progresso); ?>%">
        <?php echo e($progresso); ?> %
    </div>
</div>

<div class="search">
    <?php if(Session::has('search')): ?>
        <script>
            $(document).ready(function() {
                $('input[type=search]').val('<?php echo Session::get('search') ?>');
            });
        </script>
    <?php endif; ?>
    <?php if(isset($grupo_id)): ?>
        <input type="search" class="search-input" placeholder="Pesquisar..." results="0" onsearch="OnSearch(this, <?php echo e($grupo_id); ?>)">
        <i class="fas fa-search search-icon" onclick="Search(<?php echo e($grupo_id); ?>)"></i>
    <?php else: ?>
        <input type="search" class="search-input" placeholder="Pesquisar..." results="0" onsearch="OnSearch(this, <?php echo e($grupo->id); ?>)">
        <i class="fas fa-search search-icon" onclick="Search(<?php echo e($grupo->id); ?>)"></i>
    <?php endif; ?>
</div>

<?php $tarefaPai = 0 ?>
<?php $__currentLoopData = $tarefasNaoFeitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tnf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($tnf->tarefa_id == null): ?>
        <?php if($tarefaPai > 0): ?>
            </div>
        <?php endif; ?>
        <div class="divTarefa" id="<?php echo e($tnf->id); ?>">
            <div class='tarefa'>
                <i class="fas fa-chevron-circle-down open-subTask"></i>
                <label class="containerCheckbox"><?php echo e($tnf->nome); ?>

                    <input type="hidden" value="">
                    <?php if(Auth::user()->isAluno()): ?>
                        <input class="input-pai" type="checkbox" <?php if(($tnf->estado)): ?> checked <?php endif; ?> >
                    <?php else: ?>
                        <input class="input-pai" type="checkbox" disabled <?php if(($tnf->estado)): ?> checked <?php endif; ?> >
                    <?php endif; ?>
                    <span class="checkmark"></span>
                </label>
                <?php if(Auth::user()->isAluno()): ?>
                    <i class="fas fa-edit" onclick="EditTarefa(<?php echo e($tnf->id); ?>)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                <?php else: ?>
                    <i class="fas fa-edit" onclick="EditTarefa(<?php echo e($tnf->id); ?>, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                <?php endif; ?>

                <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                <div class="ficheirosTarefa">
                    <?php if(Auth::user()->isAluno()): ?>
                        <div class='ficheiroTarefa'><i class="fas fa-file addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[3, <?php echo e($tnf->id); ?>]"></i></div>
                        <div class='notaTarefa'><i class="fas fa-sticky-note addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[1, <?php echo e($tnf->id); ?>]"></i></div>
                        <div class='linkTarefa'><i class="fas fa-link addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[2, <?php echo e($tnf->id); ?>]"></i></div>
                    <?php endif; ?>
                    <?php if(!is_null($tnf->atribuido)): ?>
                        <div class='nameUser'><span><?php echo e($tnf->atribuido); ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php $tarefaPai++; ?>
    <?php else: ?>
            <div class="divSubTarefa <?php echo e($tnf->tarefa_id); ?>" id="<?php echo e($tnf->id); ?>">
                <div class='tarefa'>
                    <label class="containerCheckbox"><?php echo e($tnf->nome); ?>

                        <input type="hidden" value="">
                        <?php if(Auth::user()->isAluno()): ?>
                            <input type="checkbox" <?php if(($tnf->estado)): ?> checked <?php endif; ?> >
                        <?php else: ?>
                            <input type="checkbox" disabled <?php if(($tnf->estado)): ?> checked <?php endif; ?> >
                        <?php endif; ?>
                        <span class="checkmark"></span>
                    </label>
                    <?php if(Auth::user()->isAluno()): ?>
                        <i class="fas fa-edit" onclick="EditTarefa(<?php echo e($tnf->id); ?>)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                    <?php else: ?>
                        <i class="fas fa-edit" onclick="EditTarefa(<?php echo e($tnf->id); ?>, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>
                    <?php endif; ?>

                    <!-- Notas/Aluno/Ficheiro/Link -> Tarefa -->
                    <div class="ficheirosTarefa">
                        <?php if(Auth::user()->isAluno()): ?>
                            <div class='ficheiroTarefa'><i class="fas fa-file addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[3, <?php echo e($tnf->id); ?>]"></i></div>
                            <div class='notaTarefa'><i class="fas fa-sticky-note addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[1, <?php echo e($tnf->id); ?>]"></i></div>
                            <div class='linkTarefa'><i class="fas fa-link addToTarefa" role="button" data-toggle="modal" data-target="#addToTarefa" data-id="[2, <?php echo e($tnf->id); ?>]"></i></div>
                        <?php endif; ?>
                        <?php if(!is_null($tnf->atribuido)): ?>
                            <div class='nameUser'><span><?php echo e($tnf->atribuido); ?></span></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if(Session::has('search')): ?>
                <script>
                    $(document).ready(function() {
                        $('#<?php echo e($tnf->id); ?>').css('display', 'block');
                    });
                </script>
            <?php endif; ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($tarefaPai > 0): ?>
    </div>
<?php endif; ?>

<div id="tarefasFeitas">
    <?php $tarefaPai = 0 ?>
    <?php $__currentLoopData = $tarefasFeitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($tf->tarefa_id == null): ?>
            <?php if($tarefaPai > 0): ?>
                </div>
            <?php endif; ?>
            <div class="divTarefa" id="<?php echo e($tf->id); ?>">
                <div class='tarefa'>
                    <i class="fas fa-chevron-circle-down open-subTask"></i>
                    <label class="containerCheckbox"><?php echo e($tf->nome); ?>

                        <input type="hidden" value="">
                        <?php if(Auth::user()->isAluno()): ?>
                            <input class="input-pai" type="checkbox" <?php if(($tf->estado)): ?> checked <?php endif; ?> >
                        <?php else: ?>
                            <input class="input-pai" type="checkbox" disabled <?php if(($tf->estado)): ?> checked <?php endif; ?> >
                        <?php endif; ?>
                        <span class="checkmark"></span>
                    </label>
                    <i class="fas fa-edit" onclick="EditTarefa(<?php echo e($tf->id); ?>, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>

                    <div class="ficheirosTarefa">
                        <?php if(!is_null($tf->atribuido)): ?>
                            <div class='nameUser'><span><?php echo e($tf->atribuido); ?></span></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php $tarefaPai++; ?>
        <?php else: ?>
                <div class="divSubTarefa <?php echo e($tf->tarefa_id); ?>" id="<?php echo e($tf->id); ?>">
                    <div class='tarefa'>
                        <label class="containerCheckbox"><?php echo e($tf->nome); ?>

                            <input type="hidden" value="">
                            <?php if(Auth::user()->isAluno()): ?>
                                <input type="checkbox" <?php if(($tf->estado)): ?> checked <?php endif; ?> >
                            <?php else: ?>
                                <input type="checkbox" disabled <?php if(($tf->estado)): ?> checked <?php endif; ?> >
                            <?php endif; ?>
                            <span class="checkmark"></span>
                        </label>
                        <i class="fas fa-edit" onclick="EditTarefa(<?php echo e($tf->id); ?>, true)" role="button" data-toggle="modal" data-target="#editTarefa"></i>

                        <div class="ficheirosTarefa">
                            <?php if(!is_null($tf->atribuido)): ?>
                                <div class='nameUser'><span><?php echo e($tf->atribuido); ?></span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if(Session::has('search')): ?>
                    <script>
                        $(document).ready(function() {
                            $('#<?php echo e($tf->id); ?>').css('display', 'block');
                        });
                    </script>
                <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if($tarefaPai > 0): ?>
        </div>
    <?php endif; ?>
</div>

<?php if(Auth::user()->isAluno()): ?>
    <div class="modal fade" id="addToTarefa" tabindex="-1" role="dialog" aria-labelledby="addToTarefaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addToTarefaLabel"><?php echo e(__('change.criarAdicionarTarefa')); ?> <span id="titleAdd"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo e(route('addFileTarefa')); ?>" id="tarefaAdd" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="tarefa_id" id="tarefa_id" value="">
                        <?php if(isset($grupo_id)): ?>
                            <input type="hidden" name="grupo_id" id="grupo_id" value="<?php echo e($grupo_id); ?>">
                        <?php else: ?>
                            <input type="hidden" name="grupo_id" id="grupo_id" value="<?php echo e($grupo->id); ?>">
                        <?php endif; ?>
                        <div class="row group">
                            <div class="col-md-12">
                                <select name="typeAddTarefa" id="typeAddTarefa" class="select-input">
                                    <option value="1"><?php echo e(__('change.nota')); ?></option>
                                    <option value="2"><?php echo e(__('change.siteLink')); ?></option>
                                    <option value="3"><?php echo e(__('change.ficheiro')); ?></option>
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="typeAddTarefa" class="labelTextModal"><?php echo e(__('change.criar_adicionar')); ?></label>
                            </div>
                        </div>
                        
                        <div id="modalT-1" class="modal-tab"><!-- Nota -->
                            <div class="row group">
                                <div class="col-md-12">
                                    <input type="text" class="display-input" id="nomeNota" name="nomeNota">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="nomeNota" class="labelTextModal"><?php echo e(__('change.titulo')); ?></label>
                                </div>
                            </div>
                            <div class="row group">
                                <div class="col-md-12">
                                    <textarea name="notaTexto" cols="63" rows="3" class="area-input" maxlength="4000" id="notaTexto"></textarea>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="notaTexto" class="labelAreaModal"><?php echo e(__('change.texto')); ?></label>
                                </div>
                            </div>
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" onclick="Save('tarefaAdd', '/addNotaTarefa')" style="display: inline-block !important"><?php echo e(__('change.criar')); ?></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important"><?php echo e(__('change.fechar')); ?></button>
                                </div>
                            </div>
                        </div>
                        <div id="modalT-2" class="modal-tab"><!-- Link -->
                            <div class="row group">
                                <div class="col-md-6">
                                    <input type="text" class="display-input" id="nomeLink" name="nomeLink">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="nomeLink" class="labelTextModal"><?php echo e(__('change.nome')); ?></label>
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
                                    <button type="button" class="btn btn-primary" onclick="Save('tarefaAdd', '/addLinkTarefa')" style="display: inline-block !important"><?php echo e(__('change.criar')); ?></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important"><?php echo e(__('change.fechar')); ?></button>
                                </div>
                            </div>
                        </div>
                        <div id="modalT-3" class="modal-tab"><!-- Ficheiro -->
                            <div class="row group">
                                <div class="col-md-12">
                                    <input type="file" id="grupoFile" name="grupoFile">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label for="grupoFile" class="labelTextModal"><?php echo e(__('change.ficheiro')); ?></label>
                                </div>
                            </div>
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" style="display: inline-block !important"><?php echo e(__('change.criar')); ?></button>
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

<div class="modal fade" id="editTarefa" tabindex="-1" role="dialog" aria-labelledby="editTarefaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTarefaLabel"><?php echo e(__('change.criar_adicionar')); ?> <span id="titleAdd"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="editTarefaForm" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="tarefa_id" id="tarefa_id" value="">
                    <?php if(isset($grupo_id)): ?>
                        <input type="hidden" name="grupo_id" id="grupo_id" value="<?php echo e($grupo_id); ?>">
                    <?php else: ?>
                        <input type="hidden" name="grupo_id" id="grupo_id" value="<?php echo e($grupo->id); ?>">
                    <?php endif; ?>
                    
                    <!-- <div id="editT-1" class="modal-tab"> -->
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="text" name="nomeTarefa" class="display-input edit" id="nomeTarefa">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="nomeTarefa" class="labelTextModal"><?php echo e(__('change.nomeTarefa')); ?></label>
                            </div>
                            <div class="col-md-6">
                                <select name="membro" id="membro" class="select-input">
                                    <option value="" id="membro_0">--<?php echo e(__('change.selecionarPessoa')); ?>--</option>
                                    <?php $__currentLoopData = $membros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($membro->id); ?>" id="membro_<?php echo e($membro->id); ?>"><?php echo e($membro->nome); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="membro" class="labelTextModal"><?php echo e(__('change.atribuirA')); ?></label>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-6">
                                <select name="tarefaAssociada" id="tarefaAssociada" class="select-input">
                                    <option value="" id="assoc_0">--<?php echo e(__('change.selecionarTarefa')); ?>--</option>
                                    <?php $__currentLoopData = $tarefasNaoFeitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($tarefa->tarefa_id == null): ?>
                                            <option value="<?php echo e($tarefa->id); ?>" id="assoc_<?php echo e($tarefa->id); ?>"><?php echo e($tarefa->nome); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="mensagem" class="labelTextModal"><?php echo e(__('change.associarATarefa')); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="prazo" id="prazo">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="mensagem" class="labelTextModal"><?php echo e(__('change.dataFimPrevista')); ?></label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" onclick="Save('editTarefaForm', '/editTarefaPost')" style="display: inline-block !important"><?php echo e(__('change.guardar')); ?></button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="display: inline-block !important"><?php echo e(__('change.fechar')); ?></button>
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
            data: {'id': id, 'val': val, 'update': update, 'changePai': changePai },
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