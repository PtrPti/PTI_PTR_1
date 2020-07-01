<div class="back-links">
    <a href="#" onclick="changeTab(2)"><i class="fas fa-chevron-circle-left"></i> <?php echo e(__('change.voltar')); ?></a>
</div>

<div class="split-left">
    <h5><?php echo e(__('change.ficheirosSubmetidos')); ?></h5>
    <ul class="grupoFiles">
        <?php $__currentLoopData = $feedbackFicheiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($ff->tf_id == null || $ff->tf_id == ""): ?>
                <li><i class="fas fa-file"></i><a href="<?php echo e(url('/download', ['folder' => 'grupo', 'filename' => $ff->gf_nome])); ?>"><?php echo e(explode("_", $ff->gf_nome, 2)[1]); ?></a></li> <!-- href para fazer download -->
            <?php else: ?>
                <li><i class="fas fa-file"></i><a href="<?php echo e(url('/download', ['folder' => 'tarefa', 'filename' => $ff->tf_nome])); ?>"><?php echo e(explode("_", $ff->tf_nome, 2)[1]); ?></a></li> <!-- href para fazer download -->
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<div class="split-right">
    <div class="outgoing_msg">
        <div class="sent_msg">
            <p><?php echo e($feedback->mensagem_grupo); ?></p>
            <span class="time_date"><?php echo e($feedback->created_at); ?></span>
        </div>
    </div>
    <?php if($feedback->mensagem_docente != null || $feedback->mensagem_docente != ""): ?>
        <div class="incoming_msg">
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p><?php echo e($feedback->mensagem_docente); ?></p>
                    <span class="time_date"><?php echo e($feedback->updated_at); ?> por <?php echo e($feedback->nome); ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($feedback->mensagem_grupo == null || $feedback->mensagem_grupo == ""): ?>
        <div class="type_msg">
            <div class="input_msg_write">
                <input type="text" class="write_msg" placeholder="Type a message" />
                <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </div>
    <?php endif; ?>
</div>