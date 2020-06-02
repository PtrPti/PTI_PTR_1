<?php $__env->startSection('content'); ?>
<div id="apps" class="sticky">
  <div class="nav_icons_home">

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <a href="<?php echo e(route('alunoHome')); ?>"> <img src="<?php echo e(asset('images/home_icon.png')); ?>" width=23px> Home </a>
    </div>

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <img src="<?php echo e(asset('images/disciplinas_icon.png')); ?>" width=23px> Disciplinas
        </button>
        <ul class="dropdown-menu">
            <?php $__currentLoopData = $cadeiras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e(route('pagDisciplina', ['cadeira_id' => $disciplina->id])); ?>"> <?php echo e($disciplina->nome); ?> </a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <img src="<?php echo e(asset('images/projetos_icon.png')); ?>" width=23px> Projetos
        </button>
        <ul class="dropdown-menu">
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('pagProjeto', ['id' => $proj->id])); ?>"> <?php echo e($proj->projeto); ?> | Grupo Nº<?php echo e($proj->numero); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>      
  </div>          
</div>

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
    <div class="dropdown" style="height: 15px;">
      <h4 style="margin:15px;margin-right: 30px;"> Projetos </h4>
      <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="#" style="background-color: #eee9e9;">
        <img src="<?php echo e(asset('images/filter.png')); ?>" class="filtro_projeto">
      </a>
      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="position: absolute;top: 24px;right: 10px;">
        <!-- <form action="/filterProj" method="post"> -->
        <div id="filtroProjeto">
          <li class="dropdown-item">
            <input type="checkbox" id="favoritos" name="favoritos">
            <label for="favoritos">Favoritos</label>
          </li>
          <li class="dropdown-item">
            <input type="checkbox" id="em_curso" name="em_curso">
            <label for="em_curso">Em curso</label>
          </li>
          <li class="dropdown-item">
            <input type="checkbox" id="terminados" name="terminados">
            <label for="terminados">Terminados</label>
          </li>
          
          <button type='button' class="filtro_btn" onclick="filterProj()">Aplicar</button>
          <!-- <button type='button' onclick="filterProj()">Aplicar</button> -->
        </div>
        <!-- </form> -->
      </ul>
    </div>

    <!-- <div class="grupo"> -->
      <!-- <?php if(count($projetos) == 0): ?>
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
      <?php endif; ?> -->
      <?php echo $__env->make('aluno.filtroProjeto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- </div> -->
  </div>
</div>

<script>
    function changeVal(val, usersGrupos_id){
      $.ajax({
        url: '/changeFavorito',
        type: 'POST',
        dataType: 'json',
        success: 'success',
        data: {'usersGrupos_id': usersGrupos_id, 'val': val, '_token':'<?php echo e(csrf_token()); ?>'},
        success: function(data){
          window.location.href = '/alunoHome';
        }
      });
    }

    function filterProj(){
      $.ajax({
        url: '/filterProj',
        type: 'GET',
        dataType: 'json',
        success: 'success',
        data: {'favoritos': $('#favoritos').is(":checked"),
           'em_curso': $('#em_curso').is(":checked"), 
           'terminados': $('#terminados').is(":checked")
          },
        success: function(data){
          $(".grupos").replaceWith(data.html);
        }
      });
    }
</script>

<?php $__env->stopSection(); ?> 

<?php echo $__env->make('layouts.app_aluno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>