<div class="flex-disciplina" id="disciplinas">
    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="disciplina" href="<?php echo e(route('indexDisciplinaDocente', ['id' => $disciplina->id])); ?>">
            <div> 
                <?php echo e($disciplina->nome); ?>

            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(sizeof($disciplinas) % 4 == 1): ?>
        <div class="emptyDiv"></div>
        <div class="emptyDiv"></div>
        <div class="emptyDiv"></div>
    <?php elseif(sizeof($disciplinas) % 4 == 2): ?>
        <div class="emptyDiv"></div>
        <div class="emptyDiv"></div>
    <?php elseif(sizeof($disciplinas) % 4 == 3): ?>
        <div class="emptyDiv"></div>
    <?php endif; ?>
</div>