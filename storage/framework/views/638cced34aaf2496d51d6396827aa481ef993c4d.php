<?php $__env->startSection('content'); ?>

<div class="main-container">
    <h5>Disciplinas</h5>
    <div class="box-container">
        <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">
                <a href="<?php echo e(route('indexDisciplinaDocente', ['id' => $disciplina->id])); ?>"><?php echo e($disciplina->nome); ?> </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
    </div>
</div>

<div class="main-container">
    <h5>Projetos <i class="fas fa-filter"></i></h5>
    <div class="search">
        <input type="search" class="search-input" placeholder="Pesquisar" results="0">
        <i class="fas fa-search search-icon"></i>
    </div>
    <div class="box-container">
        <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">
                <a href="<?php echo e(route('indexDisciplinaDocente', ['id' => $disciplina->id])); ?>">
                    <?php echo e($proj->nome); ?><br>
                    <small><?php echo e($proj->cadeira); ?></small>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>