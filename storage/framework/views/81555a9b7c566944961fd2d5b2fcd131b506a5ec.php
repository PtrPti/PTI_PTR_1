<?php $__env->startSection('content'); ?>

<h3 class="disciplinaNome"><?php echo e($cadeira[0]->nome); ?></h3>

<div class="pagDisciplina">
    <div class="navDisciplina">
        <button class="pagInicia_btn"> Página inicial </button>
        <button class="avaliacao_btn"> Avaliação </button>
        <button class="horarios_btn"> Horários </button>
        <button class="trabalho_btn"> Trabalhos </buttons>
    </div>

    <div class="disciplinasAluno">
        <div class="pagInicial" id="outer">
            <div class="infDisciplina">
                    <h4 style="color:#e6e16c;"><b>Docentes</b></h4>
                    <?php $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="infDocentes">
                        <b><?php echo e($docente->nome); ?></b>
                        <p><?php echo e($docente->email); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a class="forumDuvidas_btn" ><img src="<?php echo e(asset('images/forum_icon.png')); ?>" width=15px style="margin-top: -4px;"> Fórum de dúvidas </a>
            </div>

            <div class="forumDuvidas">
                <p><a class="return_pagIni" id="return_btn"><b>Página Inicial</b></a> > <u>Forum de Dúvidas</u></p>
                <div class="div_button">
                    <button id="add_button">Adicionar tópico à discussão</button>
                </div>
                <?php if(Session::has("serverError")): ?>
                    <p class="alert alert-danger"><?php echo e(Session::get('serverError')); ?></p>
                <?php endif; ?>
                <div id="myModal" class="modal">
                    <form action="/addTopico" method="post"> 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="cadeira_id" value="<?php echo $cadeira[0]->id ?>">
                        <div class="novo_topico">
                            <span class="close">&times;</span>
                            <h4> Novo tópico </h5><br>
                            <div class="row">
                                <div class="col-25">
                                    <label for="assunto">Assunto</label>
                                </div>
                                <div class="col-75">
                                    <input type="text" class="inputTopico" name="assunto" id="assunto" placeholder="Título do Assunto">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="mensagem">Mensagem</label>
                                </div>
                                <div class="col-75">
                                    <textarea class="inputTopico" name="mensagem"  id="mensagem" placeholder="Escreva algo.." style="height:200px"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <input class="sub_novoTopico" type="submit" value="Adicionar">
                            </div>
                        </div>
                    </form>
                </div>

                <table class="tableGrupos">
                    <tr>
                        <th>Assunto</th>
                        <th>Começado por</th>
                        <th>Respostas</th>
                        <th>Ultima resposta</th>
                    </tr>
                    <?php $__currentLoopData = $duvidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duvida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><a onclick="verMensagens(<?php echo e($duvida->id); ?>)"><?php echo e($duvida->assunto); ?></a></td>
                        <td><?php echo e($duvida->primeiro_user); ?></td>
                        <td><?php echo 'totalMensagens'?></td>
                        <td><?php echo e($duvida->ultimo_user); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
            
            <div class="divMensagens"> 
            </div>

            <div class="addMensagem">
                <div id="novaMensagem" class="modal">
                    <form action="/addMensagem" method="post"> 
                        <?php echo e(csrf_field()); ?>

                        <!-- <input type="hidden" name="duvida_id" value="<?php/* echo $duvida*/ ?>"> -->
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
                    <!-- <h4 style="text-transform: capitalize;"><?php echo e($projeto->nome); ?></h4>           -->
                    <b>Data de entrega: </b><?php echo e($projeto->data_fim); ?>  
                    <!-- <br>                
                    <button type="button" class="showGrupos" onclick="ShowGruposA(<?php echo e($projeto->id); ?>)"> Ver projeto </button> -->
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_aluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>