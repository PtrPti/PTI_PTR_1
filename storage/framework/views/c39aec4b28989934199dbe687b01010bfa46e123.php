<?php $__env->startSection('content'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 


<div class="nome_projeto">

    <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
            <h2><?php echo e($projeto->nome); ?></h2>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
</div>

<div class="nome_cadeira">
<?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <h3 class='inline'>Disciplina:</h3>
   <h3 class ='inline' id="nome_disciplina"> <?php echo e($disciplina->nome); ?> </h3>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
</div>


<div class="container">
    <div class="lado esquerdo">
        <button class="botao_projetos" >Adicionar</button>
        <img src="<?php echo e(asset('images/pdf.png')); ?>" width=30px style='position: fixed;
    top: 205px; left: 50px'></img> <a href="#" style='position: fixed;
    top: 210px; left: 110px;'>Ver Enunciado</a>
    <img src="<?php echo e(asset('images/excel.png')); ?>" width=30px style='position: fixed;
    top: 265px; left: 50px'></img> <a href="#" style='position: fixed;
    top: 270px; left: 110px;'>Abrir Excel </a>

    <img src="<?php echo e(asset('images/note.png')); ?>" width=30px style='position: fixed;
    top: 325px; left: 50px'></img> <a href="#" id="create" style='position: fixed;
    top: 330px; left: 110px;'>Bloco de Notas </a>
    
    </div>
    <div class="lado direito">
        <p class="grupos"> Grupos inscritos:</p>
        
    </div>
</div>


<script>

$("#create").click(function() {
  $(this).before("<textarea></textarea>");
  
});




</script>


<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app_docente', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>