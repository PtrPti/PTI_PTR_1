<?php if(Auth::user()->isAluno()): ?>
    <div class="row-add">
        <button id="add_button" class="add-button" data-toggle="modal" data-target="#createFeedback"><?php echo e(__('change.pedirFeedback')); ?></button>
    </div>
<?php endif; ?>

<table class="tableForum">
    <tr>
        <th></th>
        <th><?php echo e(__('change.mensagemGrupo')); ?></th>
        <th><?php echo e(__('change.dataEnvio')); ?></th>
        <th><?php echo e(__('change.resposta')); ?></th>
    </tr>
    <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><i onclick="verFeedback(<?php echo e($feedback->id); ?>)" class="fas fa-eye"></i></td>
            <td><?php echo e($feedback->mensagem_grupo); ?></td>
            <td><?php echo e($feedback->created_at); ?></td>
            <td><?php echo e($feedback->mensagem_docente); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php if(Auth::user()->isAluno()): ?>
    <div class="modal fade" id="createFeedback" tabindex="-1" role="dialog" aria-labelledby="createFeedbackLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFeedbackLabel"><?php echo e(__('change.pedirFeedback')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="createFeedbackForm">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="grupo_id" value="<?php echo e($grupo->id); ?>">
                        <input type="hidden" name="files_ids" id="files_ids" value="">
                        <div class="row group" style="margin-bottom: 45px">
                            <div class="col-md-12">
                                <div class="dropdownFiles">
                                    <!-- <span class="hida">Escolher ficheiros</span> -->
                                    <p class="multiSel">
                                        <?php echo e(__('change.escolherFicheirosFeedback')); ?>

                                        
                                    </p>
                                    <div class="multiSelect">
                                        <ul>
                                            <?php $__currentLoopData = $feedFicheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <input class="<?php echo e($ff->tipo); ?>" id="<?php echo e($ff->id); ?>" type="checkbox" name="file" value="<?php echo e($ff->id); ?>" /><?php echo e(explode("_", $ff->nome, 2)[1]); ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row group">
                            <div class="col-md-12">
                                <textarea name="message" cols="63" rows="3" class="area-input" maxlength="4000" id="message"></textarea>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label for="message" class="labelAreaModal"><?php echo e(__('change.mensagem')); ?></label>
                            </div>
                        </div>
                        <div class="row row-btn">
                            <div class="col-md-12">
                                <!-- <button type="submit" class="btn btn-primary ">Criar</button> -->
                                <button type="button" class="btn btn-primary" onclick="Save('createFeedbackForm', '/createFeedback')"><?php echo e(__('change.criar')); ?></button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('change.fechar')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function () {
        $(".dropdownFiles p").click(function () {
            if ($(".multiSelect").hasClass('show')) {
                $(".multiSelect").removeClass('show');
            }
            else {
                $(".multiSelect").addClass('show')
            }
        });

        $('.multiSelect input').click(function () {
            var text = $(this).parent().text();
            var tipo = $(this)[0].className;
            var id = $(this)[0].id;
            
            var files = $('.multiSel span').length;

            if (!$(this).is(':checked')) {
                $('span[title="' + text + '"]').remove();
                if (files == 1) {
                    $('.multiSel').empty();
                    $('.multiSel').text('Escolha os ficheiros para feedback');
                    $('#files_ids').val('');
                }
                var value = $('#files_ids').val();
                $('#files_ids').val(value.replace(id + '_' + tipo + ',',''));
            }
            else if (files == 0) {
                $('.multiSel').empty();
                var html = '<span title="' + text + '">' + text + ';</span>';
                $('.multiSel').append(html);
                $('#files_ids').val(id + '_' + tipo + ',');
            }
            else {
                var html = '<span title="' + text + '">' + text + ';</span>';
                $('.multiSel').append(html);
                var value = $('#files_ids').val();
                $('#files_ids').val(value + id + '_' + tipo + ',');
            }
        });
    });

    function verFeedback(id) {
        $.ajax({
            url: '/verFeedback',
            type: 'GET',
            dataType: 'json',
            success: 'success',
            data: { 'id': id },
            success: function (data) {
                $("#tab-3").html(data.html);
                changeTab(3, 'flex');
            }
        });
    }
</script>