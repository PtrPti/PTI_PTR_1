<?php $__env->startSection('content'); ?>

<div class="row-title">
    <h2><?php echo e($disciplina->nome); ?></h2>
    <?php if(Auth::user()->isProfessor()): ?>
        <button id="add" type="button" class="btn-title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i><?php echo e(__('change.criar_adicionar')); ?> </button>
        <ul class="dropdown-menu" aria-labelledby="add">
            <li><i class="fas fa-clipboard-list"></i><a role="button" data-toggle="modal" data-target="#addProject"> <?php echo e(__('change.projeto')); ?> </a></li>        
            <!-- <li><i class="fas fa-file"> </i> <a id="addFile" role="button" data-toggle="modal" data-target="#addFile"> Carregar Ficheiro </a></li> -->
        </ul>

        
    <?php endif; ?>
</div>

<div class="nav-tabs">
    <div class="tab tab-active" id="tab1" onclick="changeTab(1)"><?php echo e(__('change.paginaInicial')); ?></div>
    <div class="tab" id="tab2" onclick="changeTab(2)"> <?php echo e(__('change.avaliacao')); ?> </div>
    <div class="tab" id="tab3" onclick="changeTab(3)"> <?php echo e(__('change.horarios')); ?> </div>
    <?php if(Auth::user()->isProfessor()): ?>
        <div class="tab" id="tab4" onclick="changeTab(4)"> <?php echo e(__('change.alunos')); ?> </div>
    <?php endif; ?>
</div>

<div class="tab-container" id="tab-1">
    <?php echo $__env->make('disciplina.pagInicial', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="tab-container" id="tab-2">
    <?php if(Auth::user()->isProfessor()): ?>
         <div class="row-add">
            <button id="add_button" class="add-button" data-toggle="modal" data-target="#createEvaluation"><?php echo e(__('change.criarCriteriosDeAvaliacao')); ?></button>
            
        </div>

        <div class="row-add">
            <h5 class="avaliacao_titulo"><?php echo e(__('change.metodosAvaliacao')); ?></h5>
        </div>
         


         <div class="modal fade" id="createEvaluation" tabindex="-1" role="dialog" aria-labelledby="createEvaluationLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="createEvaluationLabel"><?php echo e(__('change.insiraMetodosAvaliacao')); ?></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <form method="POST" action="<?php echo e(route('createEvaluation')); ?>" id="createEvaluationForm">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="cadeira_id" value="<?php echo e($disciplina->id); ?>" required>
                            <div class="row group">
                                <div class="col-md-12">
                                    <textarea style="width:100%;" name="mensagem_criterios" cols="63" rows="3" class="area-input" maxlength="4000" id="mensagem_criterios" placeholder="<?php echo e(__('change.insiraAquiTexto')); ?>"></textarea>
                                </div>
                            </div>
                    
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary "><?php echo e(__('change.submeterCriterios')); ?></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-add">
           <table class="table" style="margin-top:40px;">
                <tbody>
                    <?php $__currentLoopData = $avaliacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td > <?php echo e($a->mensagem_criterios); ?></td>
                            <td> <a onclick="EditEvaluation(<?php echo e($a->id); ?>)" style="cursor:pointer;" data-toggle="modal" data-target="#editEvaluation"><img src="<?php echo e(asset('images/edit_perfil.png')); ?>" width=18px ></a>  <a style="cursor:pointer;" onclick="EraiseEvaluation(<?php echo e($a->id); ?>)"><img src="<?php echo e(asset('images/delete.png')); ?>" width=18px data-toggle="modal" data-target="#eraiseEvaluation"></a></td>    
                        </tr>   
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>    
        </div>


        <div class="modal fade" id="editEvaluation" tabindex="-1" role="dialog" aria-labelledby="editEvaluationLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="editEvaluationLabel"><?php echo e(__('change.editarMetodosAvaliacao')); ?></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <form method="POST" action="<?php echo e(route('changeEvaluation')); ?>" id="editEvaluationForm">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="cadeira_id" value="<?php echo e($disciplina->id); ?>" required>
                            <?php $__currentLoopData = $avaliacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="id" value="" id="avaliacao_id" required>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="row group">
                                <div class="col-md-12">
                                    <textarea style="width:100%;" name="nova_mensagem" cols="63" rows="3" class="area-input" maxlength="10000" id="nova_mensagem" placeholder="<?php echo e(__('change.insiraAquiTexto')); ?>"></textarea>
                                </div>
                            </div>
                           
                    
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary "><?php echo e(__('change.submeterCriterios')); ?></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="eraiseEvaluation" tabindex="-1" role="dialog" aria-labelledby="eraiseEvaluation" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="eraiseEvaluationLabel"><?php echo e(__('change.apagar')); ?></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <form method="POST" action="<?php echo e(route('eraiseEvaluation')); ?>" id="eraiseEvaluationForm">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="cadeira_id" value="<?php echo e($disciplina->id); ?>" required>
                            <?php $__currentLoopData = $avaliacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="id" value="" id="avaliacao_id_eraise" required>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="row group">
                                <div class="col-md-12">
                                    <h6 class="modal-title" id="eraiseEvaluation" ><?php echo e(__('change.temACertezaQueQuerApagar')); ?></h6>
                                </div>
                            </div>
                    
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary "><?php echo e(__('change.apagar')); ?></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <?php elseif(Auth::user()->isAluno()): ?>

        <div class="row-add">
            <h5 class="avaliacao_titulo1"><?php echo e(__('change.metodosAvaliacao')); ?></h5>
        </div>

        <div class="col-add">
            <?php $__currentLoopData = $avaliacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($a->mensagem_criterios == NULL): ?>
                <p style="text-align:center"> <?php echo e(__('change.aindaNaoExistemMetodosDeAvaliacao')); ?></p> 
                <?php else: ?>
                <p style="text-align:center"> <?php echo e($a->mensagem_criterios); ?></p>
                <?php endif; ?>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
        </div>



    <?php endif; ?>
   



    

    

</div>

<div class="tab-container" id="tab-3">
<?php echo e(__('change.horario')); ?>

</div>

<?php if(Auth::user()->isProfessor()): ?>

    <div class="tab-container" id="tab-4">

    <div class="row-add">
        <button id="add_button" class="add-button" data-toggle="modal" data-target="#addAluno"><?php echo e(__('change.adicionarAlunos')); ?></button>        
    </div>


    <div class="modal fade" id="addAluno" tabindex="-1" role="dialog" aria-labelledby="addAlunoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="addAlunoLabel"><?php echo e(__('change.adicioneMaisAlunos')); ?></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <form method="POST" action="<?php echo e(route('addAluno')); ?>" id="addAlunoForm">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="cadeira_id" value="<?php echo e($disciplina->id); ?>" required>
                            <input type="hidden" name="user_id" value="" required>
                            
                            <div class="row group">
                                <div class="col-md-12">
                                    <div class="search">
                                        <input type="text" name="search" id="search_aluno" placeholder="<?php echo e(__('change.pesquisar')); ?>">
                                        <i class="fas fa-search search-icon"></i>
                                    </div>
                                    <div class="match-list">
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row row-btn">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary "><?php echo e(__('change.adicionarAluno')); ?></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $__env->make('disciplina.listaAlunos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php endif; ?>

<div class="tab-container forum" id="tab-5">
    <?php echo $__env->make('disciplina.forum', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="tab-container forumMensagens" id="tab-6">
    <?php echo $__env->make('disciplina.forumMensagens', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="tab-container" id="tab-7">
    <?php echo $__env->make('disciplina.grupos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<?php if(Auth::user()->isProfessor()): ?>
    <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="addProjectLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectLabel"><?php echo e(__('change.criarPorjeto')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route ('criarProjeto', <?php echo $disciplina->id ?>) }}" id="project">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="cadeira_id" value="<?php echo e($disciplina->id); ?>" required>
                        <input type="hidden" name="form" value="addProject">
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="text" name="nome" class="display-input" id="nome">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="nome" class="labelTextModal"><?php echo e(__('change.nomeDoProjeto')); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="n_elem" class="display-input" id="n_elem" min="1" max="10" value="0" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="n_elem" class="labelTextModal"><?php echo e(__('change.numDeElementos')); ?></label>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="datainicio" id="datainicio">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="datainicio" class="labelTextModal"><?php echo e(__('change.dataInicio')); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="display-input" name="datafim" id="datafim">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="datafim" class="labelTextModal"><?php echo e(__('change.dataEntrega')); ?></label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                                <button type="button" class="btn btn-primary" onclick="Save('project', '/criarProjeto')"><?php echo e(__('change.criar')); ?></button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

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


        $(document).on('keyup', '#search_aluno', function (e) {
            var search = $('#search_aluno').val();
            $.ajax({
                type: "get",
                url: "/search_alunos",
                data: {'search': search},
                cache: false,
                success: function (data) {
                    console.log(data.html)
                    $(".match-list").empty();
                    $(".match-list").html(data.html);
                },
            })
        });  
    }); 




   
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_novo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>