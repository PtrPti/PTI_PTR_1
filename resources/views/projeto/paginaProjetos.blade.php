@extends('layouts.app_docente')

@section('content')

<head>
    <meta content="width=device-width, initial-scale=1" name="viewport" />   
</head>

<div class="nome_projeto">
    @foreach($projetos as $projeto)        
        <h2>{{ $projeto->nome }}</h2>
    @endForeach 
</div>

<div class="nome_cadeira">
    @foreach($disciplinas as $disciplina)
        <h3 class='inline'>Disciplina:</h3>
        <h3 class ='inline' id="nome_disciplina"> {{ $disciplina->nome }} </h3>
    @endForeach 
</div>

<div>
    <p class="grupos"> Grupos inscritos:  {{ $gruposcount }}</p>
</div>

<table class="tableGrupos_p">
@foreach ($grupos as $grupo)
    <tr>
        <td>Grupo {{$grupo->numero}}</td>

        @foreach($projetos as $projeto)
            <td>0/{{$projeto->n_max_elementos}}</td>
        @endForeach

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

    <button class="open-button" onclick="openForm()">Chat</button>
    <div class="chat-popup" id="myForm">
        <form action="/action_page.php" class="form-container">
            <h2 class="chat_name">chat</h2>
    
            <div class="dropup">
                <button type="button" class="btgrupos"> <i class="fa fa-users"></i>    Escolha um grupo</button>
                <div class="dropup-content">
                    @foreach ($grupos as $grupo) 
                        <a href="#"> Grupo {{$grupo->numero}}</a>
                    @endForeach            
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