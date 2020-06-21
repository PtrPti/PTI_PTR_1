<?php $__env->startSection('content'); ?>

<div class="main-container">
    <h5>Disciplinas</h5>
    <div class="box-container">
        <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box">
                <a href="<?php echo e(route('indexDisciplinaDocente', ['id' => $disciplina->id])); ?>"><?php echo e($disciplina->nome); ?> </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
    </div>
</div>

<div class="main-container">
    <h5>Projetos
      <a id="dLabel" role="button" data-toggle="dropdown" class="btn-filter" data-target="#" href="#" style="background-color: #eee9e9;">
        <i class="fas fa-filter"></i>
      </a>
      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="position: absolute;top: 24px;right: 10px;">
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
        </div>
      </ul>
    </h5>
    <div class="search">
      <input type="search" class="search-input" placeholder="Pesquisar" results="0">
      <i class="fas fa-search search-icon"></i>
    </div>
    <div class="box-container" id="projetos">
      <?php echo $__env->make('aluno.filtroProjeto', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>     
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
          $("#projetos").html(data.html);
        }
      });
    }
</script>

<?php $__env->stopSection(); ?> 

<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>