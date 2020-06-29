<table class="tableForum">
    <?php if(isset($lista_alunos)): ?>
        <tr>
            <th><?php echo e(__('change.nomeAluno')); ?></th>
            <th><?php echo e(__('change.numeroAluno')); ?></th>
            <th><?php echo e(__('change.emailAluno')); ?></th>
        </tr>
        <?php $__currentLoopData = $lista_alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="user_<?php echo e($user->id); ?>">
                <td><?php echo e($user->nome); ?></td>
                <td><?php echo e($user->numero); ?></td>
                <td><?php echo e($user->email); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</table>