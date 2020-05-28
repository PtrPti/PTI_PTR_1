<?php $__env->startSection('content'); ?>

<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 

    <div class="flex-left">
        <a class="back" href="<?php echo e(route ('homeDocente', 'tab2')); ?>">« Voltar</a>

        <li class="open-dropdown has-dropdown">
            <a id="open-dropdown">Adicionar <i class="fa fa-caret-down"></i></a>
            <ul class="dropdown">
                <li class="dropdown-item">
                    <button type="button" onclick="#">Tarefa</button>
                </li>
                <li class="dropdown-item">
                    <button type="button" onclick="#">Ficheiro</button>
                </li>
            </ul>
        </li>

        <div class="flex-left-links">
            <img src="<?php echo e(asset('images/pdf.png')); ?>" class="flex-left-icon" />
            <a href="#" class="tasks_proj" >Ver Enunciado</a>
        </div>

        <div class="flex-left-links">
            <img src="<?php echo e(asset('images/excel.png')); ?>" class="flex-left-icon" /> 
            <a href="#" class="tasks_proj">Abrir Excel </a>
        </div>

        <div class="flex-left-links">
            <img src="<?php echo e(asset('images/note.png')); ?>" class="flex-left-icon" /> 
            <a href="#" class="tasks_proj" id="openNotepad">Bloco de Notas </a>
        </div>
    </div>

    <div class="flex-right">
        <div class="flex-right-header">
            <h2><?php echo e($projeto->nome); ?></h2>
            <h3>Disciplina: <a href="<?php echo e(route('indexDisciplinaDocente', $cadeira->id)); ?>"><?php echo e($cadeira->nome); ?></a></h3>
        </div>
        <div class="flex-right-container">
            <h4>Grupos inscritos:  <?php echo e($gruposcount); ?></h4>
            <table class="tableGrupos">
                <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr id="grupo_<?php echo e($grupo->id); ?>">
                    <td>
                        <?php if($grupo->total_membros == 0): ?>
                            <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                        <?php endif; ?>
                    </td>
                    <td>Grupo <?php echo e($grupo->numero); ?></td>
                    <td><?php echo e($grupo->total_membros); ?>/<?php echo $max_elementos ?></td>
                    <td><?php echo e($grupo->elementos); ?></td>
                <tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
    </div>
</div>


<script>
    $("#openNotepad").click(function() {
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>