<p>
    <a class="pagInicia_btn" id="return_btn"><b>Página Inicial</b></a> > <a class="forumDuvidas_btn" id="return_btn"><b>Forum de Dúvidas</b></a> > <u><?php echo e($duvida[0]->assunto); ?></u>
</p>

<?php $__currentLoopData = $mensagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mensagem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="mensagem">
    <h5><b><?php echo e($duvida[0]->assunto); ?></b> by <?php echo e($mensagem->user_id); ?> - <?php echo e($mensagem->created_at); ?></h5>
    <p><?php echo e($mensagem->mensagem); ?></p>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>