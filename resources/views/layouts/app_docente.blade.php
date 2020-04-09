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
    <script src="{{ asset('js/app_docente.js') }}"></script>    
    
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/f12fb584ff.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app_docente.css') }}" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    
    <link href="{{ asset('css/datetimepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('js/datetimepicker.js') }}"></script>

    <!-- Calendario Disponibilidades -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.6/fullcalendar.min.css">    
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.6/fullcalendar.min.js"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>
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
                    <a class="navbar-brand" href="{{ url('/docenteHome') }}">
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
                                <a href="{{ url('/docenteProfile') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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

        @yield('content')
    </div>


</body>
</html>
