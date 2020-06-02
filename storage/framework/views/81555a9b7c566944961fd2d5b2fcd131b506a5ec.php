<?php $__env->startSection('content'); ?>

<div class="layout_extra">

    <div class='barraLateral'>
        <div class="nav_icons">

            <a href="<?php echo e(route('alunoHome')); ?>" style="padding: 8px;"> <img src="<?php echo e(asset('images/home_icon.png')); ?>" width=23px> Home </a>
            <button class="dropdown-btn disc" style="padding: 8px;">
                <img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>" width=23px> Disciplinas 
                <i id="i-disciplina" class="caret-icon fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('pagDisciplina', ['cadeira_id' => $disciplina->id])); ?>"> <?php echo e($disciplina->nome); ?> </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button class="dropdown-btn proj" style="padding: 8px;">
                <img src="<?php echo e(asset('images/projetos_icon.png')); ?>" width=23px> Projetos
                <i id="i-projeto" class="caret-icon fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container ">
                <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('pagProjeto', ['id' => $proj->id])); ?>"> <?php echo e($proj->projeto); ?> | Grupo Nº<?php echo e($proj->numero); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>            
        </div>                       
    </div>

    <div class="pagDisciplina">
        <h3 class="disciplinaNome"><?php echo e($cadeira[0]->nome); ?></h3>

        <div id="infDisciplina">
            <div class="navDisciplina">
                <button onclick="show_pagInicial()" class="pagInicial_btn"> Página inicial </button>
                <button onclick="show_avaliacao()" class="avaliacao_btn"> Avaliação </button>
                <button onclick="show_horarios()" class="horarios_btn"> Horários </button>
                <button onclick="show_trabalho()" class="trabalho_btn"> Trabalhos </buttons>
            </div>

            <div class="disciplinasAluno">
                <div class="pagInicial" id="outer">
                    <div class="infDisciplina">
                            <h4 style="color:#524d4d;"><b>Docentes</b></h4>
                            <?php $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="infDocentes">
                                <b><?php echo e($docente->nome); ?></b>
                                <p><?php echo e($docente->email); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <a onclick="showForum(<?php echo e($cadeira[0]->id); ?>)" class="forumDuvidas_btn" ><img src="<?php echo e(asset('images/forum_icon.png')); ?>" width=15px style="margin-top: -4px;"> Fórum de dúvidas </a>
                    </div>

                    <div class="forumDuvidas">
                    </div>
                    
                    <div class="divMensagens"> 
                    </div>

                    <div class="addMensagem">
                        <div id="novaMensagem" class="modal">
                            <form action="/addMensagem" method="post"> 
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="duvida_id">
                                <div class="novo_topico">
                                    <span class="close">&times;</span>
                                    <h4> Nova mensagem </h5><br>
                                    <div class="row">
                                        <div class="col-75">
                                            <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." style="height:200px"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <input class="novaMensagem" type="submit" value="Responder">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="avalDisciplina" id="outer">
                    <a>Critérios de Avaliação</a>
                </div>

                <div class="horariosDisciplinas" id="outer">
                    <a>Imagem com os horarios</a>
                </div>
                
                <div class="pagTrabalhos" id="outer">
                    <div class="projetosDisciplina">
                        <?php $__currentLoopData = $cadeiraProjetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="projeto">
                            <a style="text-transform: capitalize; font-size:16px" onclick="ShowGruposA(<?php echo e($projeto->id); ?>)"><?php echo e($projeto->nome); ?></a><br>
                            <b>Data de entrega: </b><?php echo e($projeto->data_fim); ?>  
                        </div> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </div>

                    <div class="infProjeto">
                        <div class="inforcao_projeto">

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_aluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>