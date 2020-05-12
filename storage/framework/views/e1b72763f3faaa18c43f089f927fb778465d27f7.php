<div class="discpContainer" id="grupos">
    <div class="addBtn-row">
        <button type="button" class="addBtn" onclick="AddGrupo(<?php if (isset($projeto_id)) echo $projeto_id ?>)">Adicionar grupo</button>
        <button type="button" class="addBtn" onclick="AddMultGrupModal()">Adicionar múltiplos grupos</button>
    </div>

    <table class="tableGrupos" id="tableShowGrupos">
        <?php if(isset($grupos)): ?>
            <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="grupo_<?php echo e($grupo->id); ?>">
                <td>
                    <?php if($grupo->total_membros == 0): ?>
                        <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                    <?php endif; ?>
                </td>
                <td>Grupo <?php echo e($grupo->numero); ?></td>
                <td><?php echo e($grupo->total_membros); ?>/<?php echo $max_elementos ?></td>
                <td><?php echo e($grupo->elementos); ?></td>
            <tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </table>
</div>

<script>
    function AddGrupo(id) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'grupos': 1},
            success: function(data) {
                for(var i = 0; i < data.length; i++) {
                    $("#tableShowGrupos").append("<tr id='grupo_" + data[i][2] + "'><td><i class='fas fa-trash-alt' onclick='DeleteGroup(" + data[i][2] + ")'></i></td><td>Grupo " + data[i][0] + "</td><td>0/" + data[i][1] + "</td><td>-</td></tr>");
                }
            }
        });
    }

    function AddMultGrupo(id) {
        $.ajax({
            url: '/addGrupo',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: {'id': id, 'grupos': $('input[name=n_grupos]').val()},
            success: function(data) {
                for(var i = 0; i < data.length; i++) {
                    $("#tableShowGrupos").append("<tr id='grupo_" + data[i][2] + "'><td><i class='fas fa-trash-alt' onclick='DeleteGroup(" + data[i][2] + ")'></i></td><td>Grupo " + data[i][0] + "</td><td>0/" + data[i][1] + "</td><td>-</td></tr>");
                }
                closeForm();
            }
        });
    }

    function AddMultGrupModal() {
        $('#grupoNModal').show();
    }

    function DeleteGroup(id) {
        if(confirm('Tem a certeza que deseja apagar o grupo ?')) {
            $.ajax({
                url: 'deleteGrupo',
                type: 'POST',
                dataType: 'json',
                data: {'id': id, '_token': '<?php echo e(csrf_token()); ?>'},
                success: function(data) {
                    $("#grupo_" + id).remove();
                }
            });
        }
    }
</script>