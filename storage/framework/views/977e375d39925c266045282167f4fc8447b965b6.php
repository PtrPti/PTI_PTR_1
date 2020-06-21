<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>WeGroup</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            body {                
                background-color:#acc;
                background-repeat:no-repeat;
                background-position-y:bottom;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;                
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;                
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 35px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            h3{
                margin-top: -37px
            }

            p{
                font-size: 27px;
                position:absolute;
                left:670px;
                top:350px;               
            }

            mark{
                background-color: #e6e16c;                
            } 

            .image_logo{
                position:absolute;
                left:570px;
                top:220px;
                z-index:9999;
            }

            .image_back{
                position:absolute;
                bottom:5px;
                left:0px;
            }

            @media  only screen and (max-width: 768px) {
                /* For mobile phones: */
                [class*="image_logo"] {
                width: 35%;
                position:fixed;
                margin-left:-400px;
                align-content:center;
                top: 135px;
                }

                [class*="image_back"] {
                    width: 600px;
                    position: absolute;
                    bottom: auto;
                }
            }
        </style>
    </head>
    <body>       
        <div class="flex-center position-ref full-height ">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                <?php if(Auth::user() != null): ?>
                    <?php if(Auth::user()->isAluno()): ?>
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                    <?php elseif(Auth::user()->isProfessor()): ?>
                        <a href="<?php echo e(route('home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/login')); ?>">Iniciar Sessão</a>
                        <a href="<?php echo e(url('/registar')); ?>">Registo</a>
                    <?php endif; ?>                  
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>">Iniciar Sessão</a>
                    <a href="<?php echo e(url('/registar')); ?>">Registo</a>
                <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md">
                    <img src="<?php echo e(asset('images/big_logo.png')); ?>" width=27% class="image_logo">
                    <img src="<?php echo e(asset('images/group.svg')); ?>" width=57% class="image_back">
                </div>                

                <div class="links">
                    <p>We Group, We grow</p>
                </div>
            </div>            
        </div>        
    </body>
</html>
