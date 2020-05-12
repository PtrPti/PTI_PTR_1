<?php $__env->startSection('content'); ?>

<div class="nav_icons">
    <div class="" id="tab1" onclick="ShowHome()"><img src="<?php echo e(asset('images/home_icon.png')); ?>"> Home </div>
    <div class="" id="tab2" onclick="ShowProjetos()"><img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>"> Disciplinas </div>
    <div class="" id="tab2" onclick="ShowProjetos()"><img src="<?php echo e(asset('images/projetos_icon.png')); ?>"> Projetos </div>
</div>

<div class="homeDocente">
    <?php echo $__env->make('docente.disciplinasDocente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('docente.projetosDocente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>