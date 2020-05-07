<?php $__env->startSection('content'); ?>

<div class="homeAluno">
<div class="divDisciplinas ">
        <h4 style="margin-left:15px;">Disciplinas</h4>
        <div class="disciplina">
            <?php $__currentLoopData = $cadeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cadeira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('pagDisciplina', ['cadeira_id' => $cadeira->id])); ?>"> 
                <div> 
                    <?php echo e($cadeira->nome); ?> 
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="divGrupos">
        <h4 style="margin-left:15px;">Projetos</h4>
        <div class="grupo">
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('pagProjeto', ['id' => $proj->id])); ?>">
                <div>
                    <?php echo e($proj->projeto); ?> | Grupo Nº<?php echo e($proj->numero); ?><br>
                    <small><?php echo e($proj->cadeiras); ?></small>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>      
  </div>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_aluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>