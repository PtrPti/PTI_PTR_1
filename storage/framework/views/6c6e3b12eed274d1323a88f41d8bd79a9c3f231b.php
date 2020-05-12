<?php $__env->startSection('content'); ?>

<div id="apps">
    <div class="nav_icons">
        <a > <img src="<?php echo e(asset('images/home_icon.png')); ?>" width=23px> Home </a>
        <a> <img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>" width=23px> Disciplinas </a>
        <a> <img src="<?php echo e(asset('images/projetos_icon.png')); ?>" width=23px> Projetos </a>
        <a> <img src="<?php echo e(asset('images/calendario_icon.png')); ?>" width=23px> Calendário </a>                
    </div>

    <div class="chat_icon">
        <img src="<?php echo e(asset('images/chat_icon.png')); ?>" width=40px>
    </div>

    <div class=chat>        
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>