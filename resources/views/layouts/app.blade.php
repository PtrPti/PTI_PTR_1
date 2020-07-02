<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WeGroup') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/registo.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/registo.css') }}" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div id="app">

    


             
        <div class="container">

            <a class="voltar_reg_log" href="{{ route('welcome') }}" >{{ __('change.voltarPaginaInicial') }}</a>

            <a class="pt_reg_log" href="{{ url('locale/PT') }}" ><img src="{{ asset('images/pt.png') }}" width=32px ></a>
            <a class="en_reg_log" href="{{ url('locale/EN') }}" ><img src="{{ asset('images/uk.png') }}" width=32px ></a>

        </div>

        @yield('content')
    </div>




</body>
</html>