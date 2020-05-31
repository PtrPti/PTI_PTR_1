<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app_aluno.name', 'WeGroup') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app_aluno.css') }}" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app_aluno.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <!-- <span class="sr-only">Toggle Navigation</span> -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/alunosHome') }}">
                        <img src="{{ asset('images/big_logo.png') }}" width=88px>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <!-- <ul class="nav navbar-nav">
                        &nbsp;
                    </ul> -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Inicar Sessão</a></li>
                            <li><a href="{{ route('registar') }}">Registo</a></li>
                        @else
                            <div>
                                <div class="dropdown" >
                                    <a class="dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img id="user" src="{{ asset('images/pessoa.png') }}"> 
                                    </a>
                                    
                                    <!-- <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->nome }} <span class="caret"></span> 
                                    </a> -->
                                    <div class="dropdown-menu" id="peril_page" aria-labelledby="dropdownMenuLink">
                                        <li><a><img id="user_img" src="{{ asset('images/pessoa.png') }}"> </a></li>
                                        <li><a id="user_name"><b>{{ Auth::user()->nome}}</b></a></li>
                                        <li><a id="user_email">{{ Auth::user()->email}}</a></li>
                                        <li><a href="{{ route('perfilAluno') }}" id="perfil">Gerir conta</a></li>
                                        <!-- <a class="dropdown-item" id="user_numero">{{ Auth::user()->numero}}</a> -->
                                        <li class="divider"></li>
                                        <li> <a id="logout" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <img src="{{ asset('images/logout.png') }}" width=20px>   Terminar sessão</a></li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                                <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nome }} <span class="caret"></span>
                                </a>                          
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                  -->
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="chat_icon">
            <img src="{{ asset('images/chat_icon.png') }}" width=40px>
        </div>

        <div class=chat>        
        </div>
        @yield('content')
    </div>
</body>
</html>
