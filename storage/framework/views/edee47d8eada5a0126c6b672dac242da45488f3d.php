<!-- <div id="projetos" class="flex-projetos">
    <button id='button' class="btn" onclick="OpenModal()"> Criar Novo Projeto</button>
    <div class="centered">
        <p>Projetos</p>
        <ul>
        <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li> <a href="<?php echo e(route('id_projeto', ['id' => $projeto->id])); ?>"><?php echo e($projeto->nome); ?> </a> <a href='#'><img src="<?php echo e(asset('images/edit.png')); ?>" width=10px style="position: relative; left: 30px;"></a><a href='#'><img src="<?php echo e(asset('images/lixo.png')); ?>" width=10px style="position: relative; left: 50px;"></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    
</div> -->

<div class="divGrupos">
    <h4 style="margin:15px;margin-right: 30px;"> Projetos </h4>
    <div class="grupo">
        <?php if(count($projetos) == 0): ?>
            <p>Não está inscrito em nenhum projeto/grupo</p>                                   
        <?php else: ?>
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('id_projeto', ['id' => $proj->id])); ?>">
                <div>
                    <?php echo e($proj->nome); ?><br>
                    <small><?php echo e($proj->cadeira); ?></small>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        <?php endif; ?>
    </div>

    <div class="model-content">
        <div class="close" onclick="closeForm()" >x</div>
        <h4>Novo Projeto</h4>
        
        <form id="add_project" action="<?php echo e(route('projetoPost')); ?>" enctype="multipart/form-data" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="text" placeholder="Nome do Projeto" name="nome">
            <input type="number" placeholder="Número de elementos" name="n_elem">
            <div>
                <select class="form-control" name="cadeira_id" id="cadeirasProfessor" required>
                    <option value="" style="text align: center;"> Escolha uma Disciplina </option>
                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($disciplina->id == old('disciplina_id')): ?>
                            <option value="<?php echo e($disciplina->id); ?>" selected><<?php echo e($disciplina->nome); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($disciplina->id); ?>"><?php echo e($disciplina->nome); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>                    
            </div>
            <input type="file" name="ficheiro">
                
            <input type="text" class="date" name="datafim" required>

            <button type="submit">Adicionar</button>
        </form>
    </div>
</div>

<script>
    $('.date').datetimepicker({
        dateFormat: "dd-mm-yy"
    });

    function OpenModal() {
        $('.model-content').show();
    }

    function closeForm() {
        $('.model-content').hide();
    }
</script>