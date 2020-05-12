<?php $__env->startSection('content'); ?>

<div class="homeAluno">    
  <div class="divDisciplinas">
      <h4 style="margin-left:15px;">Disciplinas</h4>
      <div class="disciplina">
          <?php $__currentLoopData = $cadeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('pagDisciplina', ['cadeira_id' => $disciplina->id])); ?>"> 
              <div> 
                  <?php echo e($disciplina->nome); ?> 
              </div>
          </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
  </div>

  <div class="divGrupos">
    <div class="dropdown">
      <h4 style="margin:15px;margin-right: 30px;"> Projetos </h4>
      <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="#" style="background-color: #eee9e9;">
        <img src="<?php echo e(asset('images/filter.png')); ?>" class="filtro_projeto">
      </a>
      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="top: 24px;left: -56px;">
        <li class="dropdown-item">
          <input type="checkbox" id="favoritos" />
          <label for="favoritos">Favoritos</label>
        </li>
        <li class="dropdown-item">
          <input type="checkbox" id="em_curso" />
          <label for="em_curso">Em curso</label>
        </li>
        <li class="dropdown-item">
          <input type="checkbox" id="terminados" />
          <label for="terminados">Terminados</label>
        </li>
      </ul>
    </div>

    <div class="grupo">
      <?php if(count($projetos) == 0): ?>
          <p>Não está inscrito em nenhum projeto/grupo</p>                                   
      <?php else: ?>
          <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('pagProjeto', ['id' => $proj->id])); ?>">
              <div>
                  <?php echo e($proj->projeto); ?> | Grupo Nº<?php echo e($proj->numero); ?><br>
                  <small><?php echo e($proj->cadeiras); ?></small>
              </div>
          </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_aluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>