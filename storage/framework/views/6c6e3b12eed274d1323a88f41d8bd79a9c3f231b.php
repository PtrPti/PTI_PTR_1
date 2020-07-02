<?php $__env->startSection('content'); ?>

<div class="main-container">
    <h5><?php echo e(__('change.disciplinas')); ?></h5>
    <div class="box-container">
        <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">
                <a href="<?php echo e(route('disciplina', ['id' => $disciplina->id])); ?>"><?php echo e($disciplina->nome); ?> </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
    </div>
</div>

<div class="main-container">
  <?php if(Auth::user()->isAluno()): ?>
    <h5><?php echo e(__('change.projetos')); ?>

      <a id="dropdownMenu" role="button" data-toggle="dropdown" class="btn-filter" data-target="#" href="#" style="background-color: #eee9e9;">
        <i class="fas fa-filter"></i>
      </a>
      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="position: absolute;top: 24px;right: 10px;">
        <div id="filtroProjeto">
          <li class="dropdown-item">
            <input type="checkbox" id="favoritos" name="favoritos">
            <label for="favoritos"><?php echo e(__('change.favoritos')); ?></label>
          </li>
          <li class="dropdown-item">
            <input type="checkbox" id="em_curso" name="em_curso">
            <label for="em_curso"><?php echo e(__('change.em_curso')); ?></label>
          </li>
          <li class="dropdown-item">
            <input type="checkbox" id="terminados" name="terminados">
            <label for="terminados"><?php echo e(__('change.terminados')); ?></label>
          </li>
          
          <button type='button' class="filtro_btn" onclick="filterProj()"><?php echo e(__('change.aplicar')); ?></button>
        </div>
      </ul>
    </h5>
  <?php else: ?>
    <h5><?php echo e(__('change.projetos')); ?></h5>
  <?php endif; ?>
    <div class="search">
        <input type="search" class="search-input" placeholder="<?php echo e(__('change.pesquisar')); ?>" results="0">
        <i class="fas fa-search search-icon"></i>
    </div> 
    <div class="box-container">
        <?php if(Auth::user()->isProfessor()): ?>
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="box">
                    <a href="<?php echo e(route('disciplina', ['id' => $proj->cadeira_id, 'tab' => 1, 'proj' => $proj->id])); ?>">
                        <?php echo e($proj->nome); ?><br>
                        <small><?php echo e($proj->cadeira); ?></small>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <?php echo $__env->make('filtroProjeto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app_novo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>