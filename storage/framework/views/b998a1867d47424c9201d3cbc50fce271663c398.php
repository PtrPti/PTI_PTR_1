
  <ul class="messages" >
    <?php if(isset($messages)): ?>
    
    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li class="message clearfix">
        <div class="<?php echo e(($message->from == Auth::id()) ? 'sent' : 'recieved'); ?>">
          <p><?php echo e($message->message); ?></p>
          <p class="date"><?php echo e(date('d M y, h:i a', strtotime($message->created_at))); ?></p>
        </div>
      </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>    
  </ul>

  <div class="input-text">
    <input type="text" name="message" class="submit writeMessage">
    <i class="fa fa-paper-plane fa-2x sendMessageIcon"></i>
  </div>
