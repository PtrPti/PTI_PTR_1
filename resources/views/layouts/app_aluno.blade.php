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
    <script src="https://kit.fontawesome.com/f12fb584ff.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app_aluno.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>

    <!-- Fullcalendar -->
    <link rel="stylesheet" href="{{ asset('fullcalendar/core/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar/daygrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar/timegrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <script src="{{ asset('fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/timegrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/interaction/main.js') }}"></script>
    <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
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
                    <a class="navbar-brand" href="{{ url('/alunoHome') }}">
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

        @yield('content')

        <div class="chat_icon">
            <img src="{{ asset('images/chat_icon.png') }}" width=40px>
        </div>

        <!-- Chat -->
        {{ csrf_field() }}
        <div class="chat_msgs">
            <div class="user-wrapper">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Conversas</h4>
                    </div>
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <input type="text" class="search-bar" placeholder="Search" id="chat_search">
                        </div>
                    </div>
                </div>

                <div class="inbox_chat">
                    @foreach ($utilizadores as $utilizador)
                        <div class="chat_list" id="{{$utilizador->id}}"> 
                            @if($utilizador->unread)
                                <span class="pending">{{ $utilizador->unread }}</span>
                            @endif
                            <div class="chat_people"> <!--quando clica tem de acrescentar a class active-->
                                <div class="chat_img"> <img src="{{ asset('images/user.png') }}" width=30px class="media-object"> </div>
                                <div class="chat_ib">
                                    <h5>{{$utilizador->nome}}<span class="chat_date">{{ date('d M', strtotime($utilizador->lm_date)) }}</span></h5>
                                    <p>{{ str_limit($utilizador->last_message, $limit = 35, $end = '...') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="message-wrapper" id="messages"> <!-- <div class="mesgs"> -->
            </div>
        </div>
    </div>
</body>

<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";

    $(document).ready(function () {
        $(".chat_icon").click(function(){
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
                url: "alunomessage/" + receiver_id, // need to create this route
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
                url: "/getUsers",
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
