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
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/alunosHome') }}">
                        <img src="{{ asset('images/big_logo.png') }}" width=88px >
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
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Inicar Sessão</a></li>
                            <li><a href="{{ route('registar') }}">Registo</a></li>
                        @else
                            <div class="logout_style">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nome }} <span class="caret"></span>
                                </a>                          
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form> 
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div id="apps">
            <div class="nav_icons">

                <div style="border-bottom: 1.5px solid #e6e16c;">
                    <a href="{{ route('alunoHome') }}"> <img src="{{ asset('images/home_icon.png') }}" width=23px> Home </a>
                </div>

                <div style="border-bottom: 1.5px solid #e6e16c;">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <img src="{{ asset('images/disciplinas_icon.png') }}" width=23px> Disciplinas
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($cadeiras as $cadeira)
                        <li><a href="{{ route('pagDisciplina', ['cadeira_id' => $cadeira->id]) }}"> {{$cadeira->nome}} </a></li>
                        @endforeach
                    </ul>
                </div>

                <div style="border-bottom: 1.5px solid #e6e16c;">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <img src="{{ asset('images/projetos_icon.png') }}" width=23px> Projetos
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($projetos as $proj)
                            <li><a href="{{ route('pagProjeto', ['id' => $proj->id]) }}"> {{$proj->projeto}} | Grupo Nº{{$proj->numero}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div style="border-bottom: 1.5px solid #e6e16c;">
                    <a class="nav_calendario"> <img src="{{ asset('images/calendario_icon.png') }}" width=23px> Calendário </a>                
                </div>
                
            </div>

            <div id="menuProjetos">
            </div>                
        </div>

        <div class="chat_icon">
            <img src="{{ asset('images/chat_icon.png') }}" width=40px>
        </div>

        <div class=chat>        
        </div>
        @yield('content')
    </div>
</body>
</html>
