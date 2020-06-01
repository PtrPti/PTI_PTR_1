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

    

        <button id="btnAdd" ><img src="{{ asset('images/plus_docente.png') }}" width="23"><span>Criar/Adicionar</span></button>
        <div id="dropAdd">
            <span onclick="AddFile('Enunciado')"><i class="fas fa-file-import"></i>Enunciado </span>

            <a href="https://www.google.com/drive/"><span ><i class="fab fa-google-drive"></i>Google Drive</span></a>
            <a href="https://github.com/"><span><i class="fab fa-github"></i>Github</span></a>
            <span ><i class="far fa-sticky-note"></i>Notas</span>
           
  
        </div>




    </div>
    <div id="all1" class="popUpBack">
			<div id="addSite" class='popupDiv'>
                <img class='closebtn' src="{{ asset('images/cancel.png') }}">
                <h4>Adicione um Link</h4>
                <form id="formAddLink">
                    </select>
                    <input type="text" name='nome' placeholder="nome..."><br>
                    <input type="url" name='url' placeholder="URL..."><br>
				    <input type="submit" value='Adicionar'>
                </form>
			</div>
		</div>




    <div class="flex-right1">
        <div class="flex-right-header1">
            <h2>{{ $projeto->nome }}</h2>
            <h3>Disciplina: <a href="{{ route('indexDisciplinaDocente', $cadeira->id) }}">{{ $cadeira->nome }}</a></h3>
        </div>
        <div class="flex-right-container">
            <h4>Grupos inscritos:  {{ $gruposcount }}</h4>
            <table class="tableGrupos">
                @foreach ($grupos as $grupo)
                <tr id="grupo_{{$grupo->id}}">
                    <td>
                        @if ($grupo->total_membros == 0)
                            <i class="fas fa-trash-alt" onclick="DeleteGroup(<?php echo $grupo->id ?>)"></i>
                        @endif
                    </td>
                    <td><a href="{{ route('GrupoDocente', $grupo->id) }}" >Grupo {{$grupo->numero}}</a></td>
                    <td>{{$grupo->total_membros}}/<?php echo $max_elementos ?></td>
                    <td>{{$grupo->elementos}}</td>
                    <td>  
                        <div class="led-box">
                            <div class="led-green"></div>
                        </div>
                    </td>
                <tr>
                @endforeach
            </table>
        </div>




        
        
        <div class="flex-right-footer">
            <button class="footer-icon" onclick="ShowCalendar()"><i class="far fa-calendar-alt fa-2x"></i></button>
        </div>

  



        <div id='calendarContainer'>
            <div id='external-events'>
                <h4>Elementos do grupo</h4>
                <div id='external-events-list'>
                    @for ($i = 1; $i <= 6; $i++)
                        <?php $r = rand(0,255); $g = rand(0,255); $b = rand(0,255) ?>
                        <div class='fc-event' data-color="rgb({{$r}}, {{$g}}, {{$b}})" style="background-color: rgb({{$r}}, {{$g}}, {{$b}}); border-color: rgb({{$r}}, {{$g}}, {{$b}})">My Event {{$i}}</div>
                    @endfor
                </div>
            </div>

            <div id='calendar'></div>

            <div style='clear:both'></div>

        </div>
    </div>
</div>


<script>
    $("#openNotepad").click(function() {});

    function CriarProjeto() {
        $('.model-content').hide();
        $('#projetoModal').show();
    }

    function AddFile(title) {
        $('.model-content').hide();
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    function closeForm() {
        $('.model-content').hide();
    }

    $(document).mouseup(function(e) {
        var container = $("#dropAdd");
        if ((!container.is(e.target) && container.has(e.target).length === 0)){
            container.hide();
        }
        else {
            container.show();
        }
    });

    $("#dropAdd").hide();

    $("#btnAdd").click(function(){
        $("#dropAdd").show();
    }); 

    $(".closebtn").click(function(){
        ($($(this).parent()).parent()).hide();
    });


    function Showfeedback() {
                document.getElementById("chat").style.display = "block";
            }
            function closeForm() {
               
               
             document.getElementById("chat").style.display = "none";
            }


    
    function AddFile(title) {
        $('.model-content').hide();
        $('#fileModal').show();
        $('#titleModal').text(title);
    }

    $(".popUpBack").hide();

    $(".siteadd").click(function(){
        $("#all1").show();
    }); 




    // Feedback

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

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// more feedback content








    

</script>

@endsection