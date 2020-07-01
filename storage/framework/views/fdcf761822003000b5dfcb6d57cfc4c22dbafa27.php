<div class="back-links">
    <a href="#" onclick="changeTab(1)">Pág. Inicial</a> > <a href="#" onclick="changeTab(5)"><?php echo e(__('change.forumDuvidas')); ?></a> > <b><span class="breadcrum"><span></b>
</div>

<?php if(isset($mensagens)): ?>
    <?php $width = 98; $bloco = 0; ?>
        <?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensagem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($mensagem->bloco > $bloco) { $bloco = $mensagem->bloco; $width = 97; } ?>
            <div class="mensagem" id="mensagem_<?php echo e($mensagem->id); ?>" style="width: <?php echo e($width . '%'); ?>">
                <h5><b><?php echo e($duvida->assunto); ?></b> <?php echo e(__('change.por')); ?> <?php echo e($mensagem->nome); ?> - <?php echo e(date('l, jS F Y, H:i', strtotime($mensagem->created_at))); ?></h5>
                <p><?php echo e($mensagem->mensagem); ?></p>

                <div class="row-btn">
                    <button type="button" onclick="ReplyMensagem(<?php echo e($mensagem->id); ?>)"><?php echo e(__('change.responder')); ?> <i class="fas fa-reply"></i></button>
                </div>

                <div class="reply" id="reply_<?php echo e($mensagem->id); ?>">
                    <form action="#" method="POST" id="replyForm_<?php echo e($mensagem->id); ?>">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="mensagem_id" id="mensagem_id" value="<?php echo e($mensagem->id); ?>">
                        <input type="hidden" name="duvida_id" id="duvida_id" value="<?php echo e($duvida->id); ?>">
                        <input type="hidden" name="cadeira_id" id="cadeira_id" value="<?php echo e($duvida->cadeira_id); ?>">
                        <textarea class="inputTopico" name="resposta" id="resposta" placeholder="Escreva a sua resposta..." rows="5"></textarea>
                        <div class="row-btn">
                            <button type="button" class="btn btn-primary" onclick="Save('replyForm_<?php echo e($mensagem->id); ?>', '/replyForum')"><?php echo e(__('change.submeter')); ?></button>
                            <button type="button" id="cancel" onclick="CancelReply(<?php echo e($mensagem->id); ?>)"><?php echo e(__('change.cancelar')); ?></button>
                        </div>
                    </form>
                </div>
                <?php $width-- ; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
    function ReplyMensagem(id) {
        $('#reply_' + id).show();
    }

    function CancelReply(id) {
        $('#reply_' + id).hide();
    }
</script>