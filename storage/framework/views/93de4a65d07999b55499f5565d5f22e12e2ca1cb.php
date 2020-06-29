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
    <script src="<?php echo e(asset('js/registo.js')); ?>"></script>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/registo.css')); ?>" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="<?php echo e(asset('css/datetimepicker.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('js/datetimepicker.js')); ?>"></script>
</head>
<body>
    <div id="app">

    


             
        <div class="container">

            <a class="voltar_reg_log" href="<?php echo e(route('welcome')); ?>" ><?php echo e(__('change.voltarPaginaInicial')); ?></a>

            <a class="pt_reg_log" href="<?php echo e(url('locale/PT')); ?>" ><img src="<?php echo e(asset('images/pt.png')); ?>" width=32px ></a>
            <a class="en_reg_log" href="<?php echo e(url('locale/EN')); ?>" ><img src="<?php echo e(asset('images/uk.png')); ?>" width=32px ></a>

        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </div>




</body>
</html>