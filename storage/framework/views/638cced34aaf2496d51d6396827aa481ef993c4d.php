<?php $__env->startSection('content'); ?>

<div class="nav_icons">
    <div class="" id="tab1" onclick="ShowHome()"><img src="<?php echo e(asset('images/home_icon.png')); ?>"> Home </div>
    <div class="has-dropdown" id="tab2" onclick="ShowDisciplinas()"><img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>"> Disciplinas 
        <ul class="dropdown">
            <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="dropdown-item">
                <a href="<?php echo e(route('indexDisciplinaDocente', ['id' => $d->id])); ?>" class="item-link"><?php echo e($d->nome); ?></a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <div class="has-dropdown" id="tab3" onclick="ShowProjetos()"><img src="<?php echo e(asset('images/projetos_icon.png')); ?>"> Projetos 
        <ul class="dropdown">
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="dropdown-item">
                <a href="<?php echo e(route('id_projeto', ['id' => $p->id])); ?>" class="item-link"><?php echo e($p->nome); ?></a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>

<div class="homeDocente">
    <?php echo $__env->make('docente.disciplinasDocente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('docente.projetosDocente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>