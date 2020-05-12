<div class="divDisciplinas">
      <h4 style="margin-left:15px;">Disciplinas</h4>
      <div class="disciplina">
          <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('indexDisciplinaDocente', ['id' => $disciplina->id])); ?>"> 
              <div> 
                  <?php echo e($disciplina->nome); ?> 
              </div>
          </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
  </div>