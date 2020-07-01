<h4><b><?php echo e(__('change.docentes')); ?></b></h4>
<ul>
    <?php $__currentLoopData = $docentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><b><?php echo e($docente->nome); ?></b> (<?php echo e($docente->email); ?>)</li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php if(sizeof($projetos_cadeira) > 0): ?>
    <h4><b><?php echo e(__('change.projetos')); ?></b></h4>
    <ul>
        <?php $__currentLoopData = $projetos_cadeira; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="#" onclick="ShowGrupos(<?php echo e($p->id); ?>);" id="proj-<?php echo e($p->id); ?>"><?php echo e($p->nome); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>
<a href="#" onclick="changeTab(5)" id="btn-forumDuvidas"><?php echo e(__('change.forumDuvidas')); ?> <i class="fas fa-users"></i></a>

<script>
    function ShowGrupos(id) {
        $.ajax({
            url: '/showGrupos',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $("#tab-7").html(data.html);
                changeTab(7, 'flex', data.nome);
            }
        });
    }
</script>