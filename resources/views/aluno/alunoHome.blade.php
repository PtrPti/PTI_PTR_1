@extends('layouts.app_aluno')

@section('content')

<div class="homeAluno">
<div class="divDisciplinas ">
        <h4 style="margin-left:15px;">Disciplinas</h4>
        <div class="disciplina">
            @foreach ($cadeiras as $cadeira)
            <a href="{{ route('pagDisciplina', ['cadeira_id' => $cadeira->id]) }}"> 
                <div> 
                    {{$cadeira->nome}} 
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="divGrupos">
        <h4 style="margin-left:15px;">Projetos</h4>
        <div class="grupo">
            @foreach ($projetos as $proj)
            <a href="{{ route('pagProjeto', ['id' => $proj->id]) }}">
                <div>
                    {{$proj->projeto}} | Grupo Nº{{$proj->numero}}<br>
                    <small>{{$proj->cadeiras}}</small>
                </div>
            </a>
            @endforeach
        </div>
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
  </script>

@endsection