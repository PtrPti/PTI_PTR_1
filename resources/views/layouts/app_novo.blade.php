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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/novo.js') }}"></script>

    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/f12fb584ff.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Calendario Disponibilidades -->
    <link rel="stylesheet" href="{{ asset('fullcalendar/core/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar/daygrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar/timegrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <script src="{{ asset('fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/timegrid/main.js') }}"></script>
    <script src="{{ asset('fullcalendar/interaction/main.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
</head>
<body>
    @if (!Auth::user()->isAdmin())
        <div class="notifications">
            <i class="fas fa-bell fa-2x"></i>
            <!-- <span class="notifNum">2</span> -->
        </div>
    @endif
    <nav class="navsidebar">
        <ul class="navsidebar-nav">
            <li class="logo">
                @if (!Auth::user()->isAdmin())
                    <a href="{{ route('home') }}" class="navsidebar-link">
                        <span class="link-text logo-text">WeGroup</span>
                    </a>
                @else
                    <a href="{{ route('homeAdmin') }}" class="navsidebar-link">
                        <span class="link-text logo-text">WeGroup</span>
                    </a>
                @endif
            </li>

            <li class="navsidebar-text">
                <span>Olá, {{Auth::user()->getUserName()}}</span>
            </li>

            @if (!Auth::user()->isAdmin())
                <li class="navsidebar-item">
                    <a href="{{ route('home') }}" class="navsidebar-link">
                    <i class="fas fa-home fa-2x i-nav"></i>
                    <span class="link-text">Home</span>
                    </a>
                </li>
                <li class="navsidebar-item dropdown">
                    <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false" class="navsidebar-link">
                        <i class="fas fa-book fa-2x i-nav"></i>
                        <span class="link-text">Disciplinas</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        @foreach($disciplinas as $d)                
                            <li><a href="{{ route('disciplina', ['id' => $d->id]) }}" class="item-link">{{$d->nome}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="navsidebar-item dropdown">
                    <a id="pLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false" class="navsidebar-link">
                        <i class="fas fa-clipboard-list fa-2x i-nav"></i>
                        <span class="link-text">Projetos</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="pLabel">
                        @foreach($projetos as $p)
                            @if (Auth::user()->isProfessor())
                                <li><a href="{{ route('disciplina', ['id' => $p->cadeira_id, 'tab' => 1, 'proj' => $p->id]) }}" class="item-link">{{$p->nome}}</a></li>
                            @else
                                <li><a href="{{ route('projeto', ['id' => $p->grupo_id]) }}" class="item-link">{{$p->nome}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class="navsidebar-item">
                    <a href="#" class="navsidebar-link">
                    <i class="fas fa-user fa-2x i-nav"></i>
                    <span class="link-text">Perfil</span>
                    </a>
                </li>
            @else
                <li class="navsidebar-item">
                    <a href="{{ route('homeAdmin') }}" class="navsidebar-link">
                    <i class="fas fa-home fa-2x i-nav"></i>
                    <span class="link-text">Home</span>
                    </a>
                </li>
                <li class="navsidebar-item">
                    <a href="{{ route('getAnosLetivos') }}" class="navsidebar-link">
                    <i class="fas fa-graduation-cap fa-2x i-nav"></i>
                    <span class="link-text">Anos letivos</span>
                    </a>
                </li>
                <li class="navsidebar-item">
                    <a href="{{ route('getSemestres') }}" class="navsidebar-link">
                    <i class="fas fa-graduation-cap fa-2x i-nav"></i>
                    <span class="link-text">Semestres</span>
                    </a>
                </li>
                <li class="navsidebar-item">
                    <a href="{{ route('getDepartamentos') }}" class="navsidebar-link">
                    <i class="fas fa-graduation-cap fa-2x i-nav"></i>
                    <span class="link-text">Departamentos</span>
                    </a>
                </li>
                <li class="navsidebar-item">
                    <a href="{{ route('getCursos') }}" class="navsidebar-link">
                    <i class="fas fa-graduation-cap fa-2x i-nav"></i>
                    <span class="link-text">Cursos</span>
                    </a>
                </li>
                <li class="navsidebar-item">
                    <a href="{{ route('getCadeiras') }}" class="navsidebar-link">
                    <i class="fas fa-graduation-cap fa-2x i-nav"></i>
                    <span class="link-text">Disciplinas</span>
                    </a>
                </li>
                <li class="navsidebar-item">
                    <a href="{{ route('getUtilizadores') }}" class="navsidebar-link">
                    <i class="fas fa-users fa-2x i-nav"></i>
                    <span class="link-text">Utilizadores</span>
                    </a>
                </li>
                <li class="navsidebar-item"></li>
            @endif

            <li class="navsidebar-item">
                <a href="{{ route('logout') }}" class="navsidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-2x i-nav"></i>
                    <span class="link-text">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
    <main>
        @yield('content')
    </main>
    @if (!Auth::user()->isAdmin())
        <div class="chat">
            <i class="fas fa-comment fa-2x chat_icon"></i>
        </div>

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
                    @include('layouts.chat.users')
                </div>
            </div>

            <div class="message-wrapper" id="messages">
            </div>
        </div>
    @endif

    <div class="gritter">
        <h5 class="gritter-title"></h5>
    </div>
</body>
@if (!Auth::user()->isAdmin())
<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";

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
@endif
</html>
