<?php $__currentLoopData = $utilizadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $utilizador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="chat_list" id="<?php echo e($utilizador->id); ?>"> 
        <?php if($utilizador->unread): ?>
            <span class="pending"><?php echo e($utilizador->unread); ?></span>
        <?php endif; ?>
        <div class="chat_people"> <!--quando clica tem de acrescentar a class active-->
            <div class="chat_img"> <img src="<?php echo e(asset('images/user.png')); ?>" width=30px class="media-object"> </div>
            <div class="chat_ib">
                <h5><?php echo e($utilizador->nome); ?><span class="chat_date"><?php echo e(date('d M', strtotime($utilizador->lm_date))); ?></span></h5>
                <p><?php echo e(str_limit($utilizador->last_message, $limit = 35, $end = '...')); ?></p>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>