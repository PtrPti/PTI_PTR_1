<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'WeGroup')); ?></title>    

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <!-- <script src="<?php echo e(asset('js/app.js')); ?>"></script> -->
    <script src="<?php echo e(asset('js/jquery-3.4.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/novo.js')); ?>"></script>

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/f12fb584ff.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/site.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">


    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <!-- Calendario Disponibilidades -->
    <link rel="stylesheet" href="<?php echo e(asset('fullcalendar/core/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('fullcalendar/daygrid/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('fullcalendar/timegrid/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/calendar.css')); ?>">
    <script src="<?php echo e(asset('fullcalendar/core/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/daygrid/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/timegrid/main.js')); ?>"></script>
    <script src="<?php echo e(asset('fullcalendar/interaction/main.js')); ?>"></script>
    <script src="<?php echo e(asset('js/calendar.js')); ?>"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
</head>
<body>
    <div class="notifications">
        <i class="fas fa-bell fa-2x"></i>
        <!-- <span class="notifNum">2</span> -->
    </div>

    <div class="languages">
        
        <ul class="navbar-nav mr-auto">
            
                <li class="nav-item ">
                
                    <a class="pt" href="<?php echo e(url('locale/PT')); ?>" ><img src="<?php echo e(asset('images/pt.png')); ?>" width=29px ></a>
                    <a class="en" href="<?php echo e(url('locale/EN')); ?>" ><img src="<?php echo e(asset('images/uk.png')); ?>" width=29px ></a>
                </li>

           
        </ul>
    </div>

    <nav class="navsidebar">
        <ul class="navsidebar-nav">
            <li class="logo">
                <a href="#" class="navsidebar-link">
                    <span class="link-text logo-text">WeGroup</span>
                </a>
            </li>

            <li class="navsidebar-text">
                <span><?php echo e(__('change.ola')); ?>, <?php echo e(Auth::user()->getUserName()); ?></span>
            </li>

            <li class="navsidebar-item">
                <a href="<?php echo e(route('home')); ?>" class="navsidebar-link">
                <i class="fas fa-home fa-2x i-nav"></i>
                <span class="link-text">Home</span>
                </a>
            </li>
            <li class="navsidebar-item dropdown">
                <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" class="navsidebar-link">
                    <i class="fas fa-book fa-2x i-nav"></i>
                    <span class="link-text"><?php echo e(__('change.disciplinas')); ?></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dLabel">
                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                
                        <li><a href="<?php echo e(route('disciplina', ['id' => $d->id])); ?>" class="item-link"><?php echo e($d->nome); ?></a></li>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            <li class="navsidebar-item dropdown">
                <a id="pLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" class="navsidebar-link">
                    <i class="fas fa-clipboard-list fa-2x i-nav"></i>
                    <span class="link-text"><?php echo e(__('change.projetos')); ?></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="pLabel">
                    <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Auth::user()->isProfessor()): ?>
                            <li><a href="<?php echo e(route('disciplina', ['id' => $p->cadeira_id, 'tab' => 1, 'proj' => $p->id])); ?>" class="item-link"><?php echo e($p->nome); ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('projeto', ['id' => $p->grupo_id])); ?>" class="item-link"><?php echo e($p->nome); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>

            <li class="navsidebar-item">
                <a href="<?php echo e(route('perfil')); ?>" class="navsidebar-link">
                <i class="fas fa-user fa-2x i-nav"></i>
                <span class="link-text"><?php echo e(__('change.perfil')); ?></span>
                </a>
            </li>

            <li class="navsidebar-item">
                <a href="<?php echo e(route('logout')); ?>" class="navsidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-2x i-nav"></i>
                    <span class="link-text">Logout</span>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>
            </li>
        </ul>
    </nav>
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <div class="chat">
        <i class="fas fa-comment fa-2x chat_icon"></i>
    </div>

    <div class="chat_msgs">
        <div class="user-wrapper">
            <div class="headind_srch">
                <div class="recent_heading">
                    <h4><?php echo e(__('change.conversas')); ?></h4>
                </div>
                <div class="srch_bar">
                    <div class="stylish-input-group">
                        <input type="text" class="search-bar" placeholder="Search" id="chat_search">
                    </div>
                </div>
            </div>

            <div class="inbox_chat">
                <?php echo $__env->make('layouts.chat.users', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>

        <div class="message-wrapper" id="messages">
        </div>
    </div>

    <div class="gritter">
        <h5 class="gritter-title"></h5>
    </div>
</body>
<script>
    var receiver_id = '';
    var my_id = "<?php echo e(Auth::id()); ?>";

    $(document).ready(function () {
        $(".chat").click(function(){
            if ($(".user-wrapper").hasClass('show')) {
                $(".user-wrapper").removeClass('show');
                $(".message-wrapper").removeClass('show');
            }
            else {
                $(".user-wrapper").addClass('show');
            }
        });

        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Pusher.logToConsole = true;

        var pusher = new Pusher('20d78dea728a19ccdd1b', {
        cluster: 'eu',
        forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            if (my_id == data.from) {
                $('#' + data.to).trigger('click', [false]);
            }   
            else if (my_id == data.to) {
            if (receiver_id == data.from) {
                // if receiver is selected, reload the selected user ...
                $('#' + data.from).trigger('click', [false]);
            } 
            else {
                // if receiver is not seleted, add notification for that user
                var pending = parseInt($('#' + data.from).find('.pending').html());
                if (pending) {
                    $('#' + data.from).find('.pending').html(pending + 1);
                } else {
                    $('#' + data.from).append('<span class="pending">1</span>');
                }
            }
            }
        });           

        $('.chat_list').click(function (event, clickedByUser = true) {
            $(this).find('.pending').remove();
            receiver_id = $(this).attr('id');
            if (clickedByUser) {
                if ($(".message-wrapper").hasClass('show') && $(".message-wrapper").hasClass(receiver_id)) {
                    $('.message-wrapper').attr('class', 'message-wrapper');
                    $('.message-wrapper').attr('id', '');
                }
                else if ($(".message-wrapper").hasClass('show') && !$(".message-wrapper").hasClass(receiver_id)){
                    $('.message-wrapper').attr('class', 'message-wrapper show ' + receiver_id);
                    $('.message-wrapper').attr('id', receiver_id);
                }
                else {
                    $('.message-wrapper').addClass('show ' + receiver_id);
                    $('.message-wrapper').attr('id', receiver_id);
                }
            }
            $.ajax({    
                    type: "get",
                    url: "/alunomessage/" + receiver_id, // need to create this route
                    data: "",
                    cache: false,
                    success: function (data) {
                        $('.message-wrapper').html(data.html);
                        scrollToBottomFunc();
                    }
                });
        });      

        $(document).on('keyup', '.write_msg', function (e) {
            var message = $(this).val();
            // check if enter key is pressed and message is not null also receiver is selected
            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val(''); // while pressed enter text box will be empty
                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "message", // need to create this post route
                    data: datastr,
                    cache: false,
                    success: function (data) {                     
                    },
                    error: function (jqXHR, status, err) {
                    },
                    complete: function () {
                        scrollToBottomFunc();
                    }
                })
            }
        });

        $(document).on('click', '.msg_send_btn', function (e) {
            var message = $('.write_msg').val();
            // check if enter key is pressed and message is not null also receiver is selected
            if (message != '' && receiver_id != '') {
                $('.write_msg').val(''); // while pressed enter text box will be empty
                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "message", // need to create this post route
                    data: datastr,
                    cache: false,
                    success: function (data) {                     
                    },
                    error: function (jqXHR, status, err) {
                    },
                    complete: function () {
                        scrollToBottomFunc();
                    }
                })
            }
        });
        
        $(document).on('keyup', '#chat_search', function (e) {
            var search = $('#chat_search').val();
            $.ajax({
                type: "get",
                url: "/getUsersDocente",
                data: {'search': search},
                cache: false,
                success: function (data) {
                    console.log(data.html)
                    $(".inbox_chat").empty();
                    $(".inbox_chat").html(data.html);
                },
            })
        });  
    });      

    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }
</script>
</html>
