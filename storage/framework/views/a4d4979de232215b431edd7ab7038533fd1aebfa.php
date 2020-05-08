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
                <tr>
                    <td>Grupo <?php echo e($grupo->numero); ?></td>
                    <td>0/<?php echo e($projeto->n_max_elementos); ?></td>
                    <td>-</td>
                <tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
        
        <div class="flex-right-footer">
            <button class="footer-icon" onclick="ShowCalendar()"><i class="far fa-calendar-alt fa-2x"></i></button>
        </div>

        <div id='calendarContainer'>
            <div id='external-events'>
                <h4>Elementos do grupo</h4>
                <div id='external-events-list'>
                    <?php for($i = 1; $i <= 6; $i++): ?>
                        <?php $r = rand(0,255); $g = rand(0,255); $b = rand(0,255) ?>
                        <div class='fc-event' data-color="rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>)" style="background-color: rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>); border-color: rgb(<?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>)">My Event <?php echo e($i); ?></div>
                    <?php endfor; ?>
                </div>
            </div>

            <div id='calendar'></div>

            <div style='clear:both'></div>

        </div>
    </div>
</div>


<script>
    $("#openNotepad").click(function() {
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>