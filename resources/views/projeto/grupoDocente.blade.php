@extends('layouts.app_docente')

@section('content')


<div class="container-flex">
    <div class="left-pane-bg">        
    </div> 
    <div class="flex-left">
        <div class="nav_icons_back">
            <div class="" onclick="IndexDocente()"><img src="{{ asset('images/home_icon.png') }}"> Home </div>
            <div class="has-dropdown"><img src="{{ asset('images/disciplinas_icon.png') }}"> Disciplinas 
                <ul class="dropdown">
                    @foreach($disciplinas as $d)
                    <li class="dropdown-item">
                        <a href="{{ route('indexDisciplinaDocente', ['id' => $d->id]) }}" class="item-link">{{$d->nome}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="has-dropdown"><img src="{{ asset('images/projetos_icon.png') }}"> Projetos 
                <ul class="dropdown">
                    @foreach($projetos as $p)
                    <li class="dropdown-item">
                        <a href="{{ route('id_projeto', ['id' => $p->id]) }}" class="item-link">{{$p->nome}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="elementos_grupo">
            @foreach ($elementos as $elemento)
                <h5>Elementos do Grupo:</h5>
                <p>  {{$elemento->nome}} {{$elemento->numero}}  </p>
            @endforeach
        </div>
    </div>

<div class="flex-right">
    <div class="flex-right-header">
        <div class="flex-right-container">
            <div class="grupos_info">
                <h1 >Grupo {{$grupo->numero}}</h1>
                <p>Feedbacks</p>
                <table class="tableGrupos1">
                    <tr>
                        <th></th>
                        <th>Mensagem do Grupo</th>
                        <th>Data de Envio</th>
                        <th>Resposta</th>                        
                    </tr>

                    <?php $top = 28; $topbtn = 0;?>
                    @foreach ($feedbacks as $feedback)
                        <tr>
                            <td class ="feed_messages" id="eye"><a onclick="showFicheiros({{$feedback->id}})" class="dropbtn"> <i class="fas fa-eye"></i></a>                            
                                <div class="box arrow-left" id="feedback_{{$feedback->id}}" style="top: {{ $top . 'px' }}" >
                                    <ul class="dropdown">
                                        @foreach($ficheiros as $ficheiro)
                                        <li class="dropdown-item1">
                                            <a href="#" class="item-link">{{$ficheiro->nome}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>                        
                            </td>
                            
                            <td class="feed_messages">  {{ str_limit($feedback->mensagem_grupo, $limit = 150, $end = '...') }} </td>
                            <td class="feed_messages">{{$feedback->created_at}}</td>
                            
                            @if($feedback->mensagem_docente == '')
                                <td class="feed_messages"> <a  id="btgrupoDocente" onclick="Showfeedback({{$feedback->id}})" style="top: {{ $topbtn . 'px' }}">  <img src="{{ asset('images/feedback.png') }}" width="21" > </a> </td>
                            @else
                                <td class="feed_messages"><a  onclick ="ShowAllFeedback({{$feedback->id}})" id ="ver_feedback">{{ str_limit($feedback->mensagem_docente, $limit = 20, $end = '...') }}</a> </td>
                            @endif
                        </tr>
                        <?php $top +=38; $topbtn +=1; ?>
                    @endforeach
                </table>

                <!--  Modal Para Ver mensagem toda -->
                <div id="ModalFeedback" class="modal_msg">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <a onclick=closeModal()> x </a>
                        <p></p>
                        <input type="hidden" name="feed_id" value=''>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="feedback-footer">
            <div class="chat-popup" id="chat">
                <form action="{{ route('AddMensagem') }}" enctype="multipart/form-data" method="post" class="form-container">
                    <input type="hidden" name="grupo_id" value='{{$grupo->id}}'>
                    <input type="hidden" name="docente_id" value='{{Auth::user()->getUserId()}}'>
                    <input type="hidden" name="feedback_id" value=''>
                    {{ csrf_field() }}  
                    
                    <div class="dropup">
                        <p>Envie um Feedback para o Grupo {{$grupo->numero}} </p>
                        
                        <div class="dropup-content">
                            <a href="#" id='print'> </a>
                        </div>
                        
                        <label for="mensagem_docente"><b style ="position: relative; top: 70px;">Mensagens</b></label>
                        <textarea name="mensagem_docente" id="message_content" placeholder="Escreva o seu feedback..." ></textarea>

                        <button  type="submit" class="btn" style = "position: absolute;top: 320px;">Enviar Feedback</button>
                        <button type="button" class="btn cancel" style ="position: absolute; top: 365px;" onclick="closeForm()">Fechar</button>   
                    </div>                        
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    
// Feedback

function Showfeedback(id) {
    $('input[name="feedback_id"]').val(id) ;
    document.getElementById("chat").style.display = "block";}
    
function closeForm() {
    document.getElementById("chat").style.display = "none";}

function closeModal() {
    document.getElementById("ModalFeedback").style.display = "none";}

function ShowAllFeedback(id) {
    $.ajax({
        url: '/showFeedback',
        type: 'GET',
        dataType: 'json',
        success: 'success',
        data: {'id': id},
        success: function(data){
            $("#ModalFeedback p" ).text(data.message);
            $("#ModalFeedback").show();
        }
    });
} 

function sendfeed(){
    var lista_feeds = [];
    var x = document.getElementById("message_content").value;
    lista_feeds.push(x);
    for(i=0; i<lista_feeds.length; i++){
        $('#print_feed').append("<p>" + lista_feeds[i] + "</p>");
    }    
    $(".chat-popup").css('display', 'none');
}
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("btgrupos");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("closef")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

$("#btn_escolha").click(function() {
    var a = $('input[name="check"]:checked').val();

    if (a) {
        $('#print').append("<a> " + a + "</a>");
    }   
    $("#myModal").css('display', 'none');
});

function showFicheiros(id) {
    $(".box").hide();
    $("#feedback_" + id).show();    
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
@endsection