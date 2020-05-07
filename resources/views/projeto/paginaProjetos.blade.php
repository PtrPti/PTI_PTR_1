@extends('layouts.app_docente')

@section('content')

<head>
    <meta content="width=device-width, initial-scale=1" name="viewport" />   
</head>

<div class="nome_projeto">  
    <h2>{{ $projeto->nome }}</h2>
</div>

<div class="nome_cadeira">
        <h3 class='inline'>Disciplina:</h3>
        <h3 class ='inline' id="nome_disciplina"> {{ $cadeira->nome }} </h3>
</div>

<div>
    <p class="grupos"> Grupos inscritos:  {{ $gruposcount }}</p>
</div>

<table class="tableGrupos_p">
@foreach ($grupos as $grupo)
    <tr>
        <td>Grupo {{$grupo->numero}}</td>
        <td>0/{{$projeto->n_max_elementos}}</td>
        <td>-</td>
    <tr>
    @endforeach
</table>

<div class="container">
    <div class="lado esquerdo">
        <button class="botao_projetos" >Adicionar</button>
        <img src="{{ asset('images/pdf.png') }}" class="img_projeto" width=30px style='position: fixed;
                top: 205px; left: 50px'></img> <a href="#" class="tasks_proj" style='position: fixed;
                top: 210px; left: 110px;'>Ver Enunciado</a>
                
        <img src="{{ asset('images/excel.png') }}" class="img_projeto" width=30px style='position: fixed;
                top: 265px; left: 50px'></img> <a href="#" class="tasks_proj" style='position: fixed;
                top: 270px; left: 110px;'>Abrir Excel </a>

        <img src="{{ asset('images/note.png') }}" class="img_projeto" width=30px style='position: fixed;
                top: 325px; left: 50px'></img> <a href="#" class="tasks_proj" id="create" style='position: fixed;
                top: 330px; left: 110px;'>Bloco de Notas </a>    
    </div>

    <div class="lado direito">
    </div>

    <div class="flex-right">
        <div class="flex-right-header">
            <h2>{{ $projeto->nome }}</h2>
            <h3>Disciplina: <a href="{{ route('indexDisciplinaDocente', $cadeira->id) }}">{{ $cadeira->nome }}</a></h3>
        </div>
        <div class="flex-right-container">
            <h4>Grupos inscritos:  {{ $gruposcount }}</h4>
            <table class="tableGrupos">
                @foreach ($grupos as $grupo)
                <tr>
                    <td>Grupo {{$grupo->numero}}</td>
                    <td>0/{{$projeto->n_max_elementos}}</td>
                    <td>-</td>
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

            <label for="msg"><b>Mensagens</b></label>
            <textarea placeholder="Escreva a sua mensagem" name="msg" required></textarea>

            <button type="submit" class="btn">Enviar Feedback</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Fechar</button>
        </form>
    </div>
</div>


<script>
    $("#create").click(function() {
        $(this).before("<textarea></textarea>");    
    });

    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>

@endsection