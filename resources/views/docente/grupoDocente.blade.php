@extends('layouts.app_docente')

@section('content')


<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 




    <div class="flex-left">

        <div class="nav_icons_back">
            <a href="{{ route('homeDocente') }}"><div><img src="{{ asset('images/home_icon.png') }}"> Home </div></a>
            <a><div><img src="{{ asset('images/disciplinas_icon.png') }}"> Disciplinas </div></a>
            <a><div><img src="{{ asset('images/projetos_icon.png') }}"> Projetos </div></a>
        </div>

        <div class="elementos_grupo">
        @foreach ($elementos as $elemento)
            <h4>Elementos do Grupo:</h4>
            <p>  {{$elemento->nome}} {{$elemento->numero}}  </p>
            @endforeach
        </div>

        <button type="button" id="btgrupoDocente" onclick="Showfeedback()">  <img src="{{ asset('images/feedback.png') }}" width="27" style="margin-right:10px"> Dar Feedback ao Grupo</button>
    </div>

<div class="flex-right">
    <div class="flex-right-header">
        <div class="flex-right-container">
            <div class="grupos_info">

                <h1 >Grupo {{$grupo->numero}}</h1>
                <p>Feedbacks</p>
                <table class="tableGrupos">
                    @foreach ($feedbacks as $feedback)
                    <tr>
                    <td id="feed_messages">{{$feedback->mensagem}}</td>
                    @endforeach
                </table>
                
            
            </div>
        </div>
    </div>

    <div class="feedback-footer">
            <div class="chat-popup" id="chat">
                <form action="{{ route('AddMensagem'), $grupo->id }}" enctype="multipart/form-data" method="post" class="form-container">
                    <input type="hidden" name="grupo_id" value='{{$grupo->id}}'>
                    {{ csrf_field() }}  
                    <h2 class="chat_name">Chat</h2>

                    <div class="dropup">
                        <p>Envie um Feedback para o Grupo {{$grupo->numero}} </p>
                        <button type="button" id="btgrupos"> <i class="fa fa-users"></i> Escolher submissão</button>

         
                        <div class="dropup-content">
                            <a href="#" id='print'> </a>
                        </div>

                        
                        <label for="msg"><b>Mensagens</b></label>
                        <textarea name="msg" id="message_content" ></textarea>

                        <button  type="submit" class="btn">Enviar Feedback</button>
                        <button type="button" class="btn cancel" onclick="closeForm()">Fechar</button>


                            

                        </div>

                        
                    </div>

                   

                   
                </form>
            </div>
        </div>
</div>



<script>
    
    // Feedback


    function Showfeedback() {
        document.getElementById("chat").style.display = "block";}
    
    function closeForm() {
        document.getElementById("chat").style.display = "none";
        }



function sendfeed(){
    var lista_feeds = [];
    var x = document.getElementById("message_content").value;
    lista_feeds.push(x);
    console.log(lista_feeds);
    for(i=0; i<lista_feeds.length; i++){
        $('#print_feed').append("<p>" + lista_feeds[i] + "</p>");
    }
    
    $(".chat-popup").css('display', 'none');

}
    




</script>


@endsection