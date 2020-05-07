<?php $__env->startSection('content'); ?>

<div class="nav_icons">
    <div class="<?php if($active_tab == 1): ?> active <?php endif; ?>" id="tab1" onclick="ShowHome()"><img src="<?php echo e(asset('images/home_icon.png')); ?>"> Home </div>
    <div class="<?php if($active_tab == 2): ?> active <?php endif; ?>" id="tab2" onclick="ShowProjetos()"><img src="<?php echo e(asset('images/projetos_icon.png')); ?>"> Projetos </div>
</div>

<script>
$(document).ready(function() {
    $("#" + "<?php echo $active_tab ?>").trigger("click");
});
</script>

<?php echo $__env->make('docente.disciplinasDocente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('docente.projetosDocente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>