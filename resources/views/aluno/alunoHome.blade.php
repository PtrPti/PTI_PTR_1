@extends('layouts.app_aluno')

@section('content')
<div id="apps" class="sticky">
  <div class="nav_icons_home">

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <a href="{{ route('alunoHome') }}"> <img src="{{ asset('images/home_icon.png') }}" width=23px> Home </a>
    </div>

    <div style="border-bottom: 1.5px solid #e6e16c;">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <img src="{{ asset('images/disciplinas_icon.png') }}" width=23px> Disciplinas
        </button>
        <ul class="dropdown-menu">
            @foreach ($disciplinas as $disciplina)
            <li><a href="{{ route('pagDisciplina', ['cadeira_id' => $disciplina->id]) }}"> {{$disciplina->nome}} </a></li>
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

    <!-- <div style="border-bottom: 1.5px solid #e6e16c;">
        <a class="nav_calendario"> <img src="{{ asset('images/calendario_icon.png') }}" width=23px> Calendário </a>                
    </div> -->
      
  </div>          
</div>


<div class="homeAluno">
    <div class="divDisciplinas ">
        <h4 style="margin-left:15px;">Disciplinas</h4>
        <div class="disciplina">
            @foreach ($disciplinas as $disciplina)
            <a href="{{ route('pagDisciplina', ['cadeira_id' => $disciplina->id]) }}"> 
                <div> 
                    {{$disciplina->nome}} 
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="divGrupos">
      <div class="dropdown" style="height: 15px;">
        <h4 style="margin:15px;margin-right: 30px;"> Projetos </h4>
        <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="#" style="background-color: #eee9e9;">
          <img src="{{ asset('images/filter.png') }}" class="filtro_projeto">
        </a>
        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="position: absolute;top: 24px;right: 10px;">
          <!-- <form action="/filterProj" method="post"> -->
          <div id="filtroProjeto">
            <li class="dropdown-item">
              <input type="checkbox" id="favoritos" name="favoritos">
              <label for="favoritos">Favoritos</label>
            </li>
            <li class="dropdown-item">
              <input type="checkbox" id="em_curso" name="em_curso">
              <label for="em_curso">Em curso</label>
            </li>
            <li class="dropdown-item">
              <input type="checkbox" id="terminados" name="terminados">
              <label for="terminados">Terminados</label>
            </li>
            <!-- <input type="submit" value="Aplicar" class="filtro_btn"> -->
<<<<<<< HEAD
            <button type='button' class="filtro_btn" onclick="filterProj()">Aplicar</button>
=======
            <button type='button' onclick="filterProj()">Aplicar</button>
>>>>>>> befa9d46e47e9407ef9c5168cb4eb863395f32bb
          </div>
          <!-- </form> -->
        </ul>
      </div>

      @include('aluno.filtroProjeto')
<<<<<<< HEAD
      
=======

     
>>>>>>> befa9d46e47e9407ef9c5168cb4eb863395f32bb
    </div>
    
          <!-- Chat -->
          {{ csrf_field() }}
      <div class="user-wrapper">
        <ul class="users">
          @foreach ($utilizadores as $utilizador)
            <li class="user" id="{{$utilizador->id}}">
              @if($utilizador->unread)
                <span class="pending">{{ $utilizador->unread }}</span>
              @endif

              <div class="media">
                <div class="media-left">
                  <img src="{{ asset('images/user.png') }}" width=30px class="media-object">
                </div>
                <div class="media-body">
                  <p class="username"> {{$utilizador->nome}}</p>
                  <p class="email">{{$utilizador->email}}</p>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>      
      
      <div class="message-wrapper" id="messages">
      </div>
  </div>

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

      $('.user').click(function (event, clickedByUser = true) {
        // alert(clickedByUser);
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

      $(document).on('keyup', '.input-text input', function (e) {
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

      $(document).on('click', '.sendMessageIcon', function (e) {
        var message = $('.writeMessage').val();
        // check if enter key is pressed and message is not null also receiver is selected
        if (message != '' && receiver_id != '') {
          $('.writeMessage').val(''); // while pressed enter text box will be empty
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
    });      

    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }

    function changeVal(val, usersGrupos_id){
      $.ajax({
        url: '/changeFavorito',
        type: 'POST',
        dataType: 'json',
        success: 'success',
        data: {'usersGrupos_id': usersGrupos_id, 'val': val, '_token':'{{csrf_token()}}'},
        success: function(data){
          window.location.href = '/alunoHome';
        }
      });
    }

    function filterProj(){
      $.ajax({
        url: '/filterProj',
        type: 'GET',
        dataType: 'json',
        success: 'success',
        data: {'favoritos': $('#favoritos').is(":checked"),
           'em_curso': $('#em_curso').is(":checked"), 
           'terminados': $('#terminados').is(":checked")
          },
        success: function(data){
          $(".grupos").replaceWith(data.html);
        }
      });
    }
</script>

@endsection 