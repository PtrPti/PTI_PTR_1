<a class="trabalho_btn" id="return_btn"><b>Trabalhos</b></a> > <u><?php echo e($projeto->nome); ?></u>

<div class="button">

</div>
<!-- <h4><b><?php echo e($projeto->nome); ?></b></h4> -->
<table class="tableGrupos">
    <tr>
        <th>Número do grupo</th>
        <th>Total de membros</th>
        <th colspan="2">Elementos</th>
    </tr>
    <?php $hasGroup = False?>
    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>Grupo <?php echo e($grupo->numero); ?></td>
        <?php 
            $membros = array();
            foreach ($elementos as $elemento){
                if(($elemento->grupo_id) == ($grupo->id)){
                    array_push($membros, $elemento);
                }
            }
            echo "<td>",count($membros),"/",$projeto->n_max_elementos,"</td><td>";
            
            $inGroup = False;
            foreach ($membros as $membro) {
                
                //ALTERAR
                foreach ($users as $actual_user){
                    if (($actual_user->id) == ($membro->user_id)){
                        echo "<a>",$actual_user->nome,"</a>";
                        if ($actual_user->id == $user){
                            $inGroup = True;
                            $hasGroup = True;
                        }
                    }
                }
            }
            echo "</td><td>";

            if(count($membros) == $projeto->n_max_elementos){
                //$novoGrupo = True;
                echo "Fechado";
            }elseif($inGroup){
                $hasGroup = True;
                //$novoGrupo = False;
                echo "<button type='button' onclick='removeUser($grupo->id, $projeto->id)'>Sair no Grupo</button>", csrf_field();
            }else{
                echo "<button type='button' onclick='addUser($grupo->id, $projeto->id)'>Entrar no Grupo</button>", csrf_field();
            }

            // if ($hasGroup){
            //     if($inGroup){
            //         echo "<button type='button' onclick='removeUser($grupo->id, $projeto->id)'>Sair no Grupo</button>", csrf_field();
            //     }
            // } else{
            //     if(count($membros) == $projeto->n_max_elementos){
            //         //$novoGrupo = True;
            //         echo "Fechado";
            //     }else{
            //         echo "<button type='button' onclick='addUser($grupo->id, $projeto->id)'>Entrar no Grupo</button>", csrf_field();
            //     }
            // }
            
            echo "</td></tr>";
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php
if($inGroup){
    echo "<button type='button' style='position:absolute;top:2%;left:35%;' id='add_button' onclick='addGroup($grupo->id, $projeto->id)'>Adicionar Grupo</button>", csrf_field();
} else{
    echo "<button type='button' style='position:absolute;top:2%;left:35%;' id='add_button' onclick='addUserGroup($grupo->id, $projeto->id)'>Adicionar Grupo</button>", csrf_field();
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
                console.log(data.html);
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
            }
        });
    }
</script>