<a onclick="return_trabalho()" id="return_btn"><b>Trabalhos</b></a> > <u><?php echo e($projeto->nome); ?></u>

<!-- <div class="button">

</div> -->
<!-- <h4><b><?php echo e($projeto->nome); ?></b></h4> -->
<table class="tableGrupos" style="margin-top:9%">
    <tr>
        <th>Número do grupo</th>
        <th>Total de membros</th>
        <th colspan="2">Elementos</th>
    </tr>
    
    <?php $inGroup = False; ?>
    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>Grupo <?php echo e($grupo->numero); ?></td>
        <td><?php echo e($grupo->total_membros); ?> / <?php echo e($projeto->n_max_elementos); ?></td>
        <td><a><?php echo e($grupo->elementos); ?></a></td>
        <td>            
            <?php 
                if ($pertenceGrupo != NULL){
                    if($grupo->id == $pertenceGrupo->grupo_id){
                        echo "<button type='button' class='buttun_group' onclick='removeUser($grupo->id, $projeto->id)'>Sair no Grupo</button>", csrf_field();
                    }else{
                        echo " ";
                    }
                    $inGroup = True; 
                }
                else{
                    if($grupo->total_membros == $projeto->n_max_elementos){
                        echo "Fechado";
                        $inGroup = True;
                    }else{
                        echo "<button type='button' class='buttun_group' onclick='addUser($grupo->id, $projeto->id)'>Entrar no Grupo</button>", csrf_field();
                    }
                }            
            ?>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php
if(!$inGroup){
    echo "<button type='button' style='position:absolute;bottom:86%;;left:52%;' id='button_style' onclick='addUserGroup($grupo->id, $projeto->id)'>Adicionar Grupo</button>", csrf_field();
}
?> 

<script>
    function removeUser(grupo_id, projeto_id) {
        $.ajax({
            url: '/removeUser',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'grupo_id': grupo_id,'_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data){
                ShowGruposA(projeto_id);
            }
        });
    }
    
    function addUser(grupo_id, projeto_id) {
        $.ajax({
            url: '/addUser',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'grupo_id': grupo_id, '_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data){
                ShowGruposA(projeto_id);
            }
        });
    }

    function addGroup(projeto_id) {
        $.ajax({
            url: '/addGroup',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'projeto_id': projeto_id, '_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data){
                ShowGruposA(projeto_id);
            }
        });
    }

    function addUserGroup(projeto_id) {
        $.ajax({
            url: '/addUserGroup',
            type: 'POST',
            dataType: 'json',
            success: 'success',
            data: {'projeto_id': projeto_id, '_token':'<?php echo e(csrf_token()); ?>'},
            success: function(data){
                ShowGruposA(projeto_id);
                $('#button_style').hide()
            }
        });
    }
</script>