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
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/app_docente.js')); ?>"></script>    
    
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/f12fb584ff.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app_docente.css')); ?>" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    
    <link href="<?php echo e(asset('css/datetimepicker.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('js/datetimepicker.js')); ?>"></script>

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
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="<?php echo e(url('/docenteHome')); ?>">
                        <img src="<?php echo e(asset('images/big_logo.png')); ?>" width=88px >
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <?php if(Auth::guest()): ?>
                            <li><a href="<?php echo e(route('login')); ?>">Inicar Sessão</a></li>
                            <li><a href="<?php echo e(route('registar')); ?>">Registo</a></li>
                        <?php else: ?>
                            <div class="logout_style">
                                <a href="<?php echo e(url('/docenteProfile')); ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <?php echo e(Auth::user()->nome); ?> <span class="caret"></span>
                                </a>                          
                                <a href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                </form> 
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div>
            <button class="footer-icon" onclick="openForm()"><i class="fas fa-comment fa-2x"></i></button>
            <div class="chat-popup" id="chat">
                <form action="/action_page.php" class="form-container">
                    <h2 class="chat_name">chat</h2>
            
                    <div class="dropup">
                        <button type="button" class="btgrupos"> <i class="fa fa-users"></i> Escolha um grupo</button>
                        <div class="dropup-content">
                            <a href="#"> Grupo 1</a>
                        </div>
                    </div>
    
                    <label for="msg"><b>Mensagens</b></label>
                    <textarea placeholder="Escreva a sua mensagem" name="msg" required></textarea>
    
                    <button type="submit" class="btn">Enviar Feedback</button>
                    <button type="button" class="btn cancel" onclick="closeForm()">Fechar</button>
                </form>
            </div>
        </div>

    <script>
        function openForm() {
            document.getElementById("chat").style.display = "block";
        }

        function closeForm() {
            document.getElementById("chat").style.display = "none";
        }
    </script>

        <?php echo $__env->yieldContent('content'); ?>
    </div>


</body>
</html>
