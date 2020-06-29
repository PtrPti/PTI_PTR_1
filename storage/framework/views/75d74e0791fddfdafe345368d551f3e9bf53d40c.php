<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <b><?php echo e(__('change.forumDuvidas')); ?></b>
</div>

<div class="row-add">
    <button id="add_button" class="add-button" data-toggle="modal" data-target="#createTopico"><?php echo e(__('change.criar_topico')); ?></button>
</div>

<table class="tableForum">
    <tr>
        <th><?php echo e(__('change.assunto')); ?></th>
        <th><?php echo e(__('change.criado_por')); ?></th>
        <th><?php echo e(__('change.respostas')); ?></th>
        <th><?php echo e(__('change.ultima_resposta')); ?></th>
    </tr>
    <?php $__currentLoopData = $duvidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duvida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><a id="duvida-<?php echo e($duvida->id); ?>" onclick="verMensagensForum(<?php echo e($duvida->id); ?>, '<?php echo e($duvida->assunto); ?>')"><?php echo e($duvida->assunto); ?></a></td>
            <td><?php echo e($duvida->primeiro); ?></td>
            <td><?php echo e($duvida->totalMensagens); ?></td>
            <td><?php echo e($duvida->ultimo); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<div class="modal fade" id="createTopico" tabindex="-1" role="dialog" aria-labelledby="createTopicoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTopicoLabel"><?php echo e(__('change.criar_topico')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="#" id="topicoForum">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="cadeira_id" value="<?php echo e($disciplina->id); ?>" required>
                    <div class="row group">
                        <div class="col-md-12">
                            <input type="text" name="assunto" class="display-input" id="assunto">
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="assunto" class="labelTextModal"><?php echo e(__('change.assunto')); ?></label>
                        </div>
                    </div>
                    <div class="row group">
                        <div class="col-md-12">
                            <textarea name="mensagem" cols="63" rows="3" class="area-input" maxlength="4000" id="mensagem"></textarea>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label for="mensagem" class="labelAreaModal"><?php echo e(__('change.mensagem')); ?></label>
                        </div>
                    </div>
                    <div class="row row-btn">
                        <div class="col-md-12">
                            <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                            <button type="button" class="btn btn-primary" onclick="Save('topicoForum', '/addForumTopico')"><?php echo e(__('change.criar')); ?></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(Session::has('click')): ?>
<script>
    $(document).ready(function() {
        $("#<?php echo Session::get('click') ?>").click();
    });
</script>
<?php endif; ?>

<script>
    function verMensagensForum(id, nome) {
        $.ajax({
            url: '/verMensagensForum',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: { 'id': id },
            success: function (data) {
                $("#tab-6").html(data.html);
                changeTab(6, 'block', nome);
            }
        });
    }
</script>