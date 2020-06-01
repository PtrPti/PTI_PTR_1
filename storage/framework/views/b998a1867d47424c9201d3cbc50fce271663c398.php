<?php if(isset($messages)): ?>
  <div class="chat_messages">    
  <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php 
        $today = new DateTime();
        $today->setTime( 0, 0, 0 ); 
        
        $match_date = DateTime::createFromFormat( "Y-m-d H:i:s", $message->created_at);
        $match_date->setTime( 0, 0, 0 );

        $diff = $today->diff( $match_date );
        $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

        $displayDate;

        if( $diffDays == 0)
        {
            $displayDate = date('h:i A | ', strtotime($message->created_at)) . 'Today';
        }
        else if ($diffDays == -1)
        {
            $displayDate = date('h:i A | ', strtotime($message->created_at)) . 'Yesterday';
        }
        else
        {
            $displayDate = date('h:i A | M', strtotime($message->created_at));
        }  
    ?>
    <?php if($message->from == Auth::id()): ?> <!-- quem envia -->
        <div class="outgoing_msg">
            <div class="sent_msg">
                <p><?php echo e($message->message); ?></p>
                <span class="time_date"><?php echo $displayDate ?></span>
            </div>
        </div>
    <?php else: ?> <!-- quem recebe -->
        <div class="incoming_msg">
            <div class="incoming_msg_img"> <img src="<?php echo e(asset('images/user.png')); ?>"></div>
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p><?php echo e($message->message); ?></p>
                    <span class="time_date"><?php echo $displayDate ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
<?php endif; ?>  

<div class="type_msg">
  <div class="input_msg_write">
    <input type="text" class="write_msg" placeholder="Type a message" />
    <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
  </div>
</div>