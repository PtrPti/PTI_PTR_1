<?php if(isset($projetos)): ?>
    <?php if(count($projetos) == 0): ?>
        <p><?php echo e(__('change.naoInscrito')); ?></p>
        
    <?php else: ?>
        <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">            
                <?php if($proj->favorito == 0): ?>
                    <img onclick="changeVal(1, <?php echo $proj->usersGrupos_id ?>)" src="<?php echo e(asset('images/favorito1.png')); ?>" />
                <?php else: ?>
                    <img onclick="changeVal(0, <?php echo $proj->usersGrupos_id ?>)" src="<?php echo e(asset('images/favorito2.png')); ?>" />
                <?php endif; ?>
                <a href="<?php echo e(route('projeto', ['id' => $proj->grupo_id])); ?>">
                    <?php echo e($proj->nome); ?> | <?php echo e(__('change.grupo')); ?> <?php echo e(__('change.num')); ?><?php echo e($proj->numero); ?><br>
                    <small><?php echo e($proj->cadeira); ?></small>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php else: ?>
    <p><?php echo e(__('change.naoExistemResultados')); ?></p>
<?php endif; ?>