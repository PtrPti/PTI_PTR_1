<button type="button" class="addBtn" onclick="AddGrupo(<?php echo $projeto ?>)">Adicionar Grupo</button>
<table class="tableGrupos">
    <tr>
        <th>Número do grupo</th>
        <th>Elementos</h>
    </tr>
    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td>Grupo <?php echo e($grupo->numero); ?></td>
        
    <tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
    function AddGrupo(id) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id},
            success: function(data){
                $(".tableGrupos").append("<tr><td>Grupo " + data.numero + "</td><td>0/" + data.max_elem + "</td><td>-</td></tr>");
            }
        });
    }
</script>