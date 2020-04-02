@extends('layouts.app_docente')

@section('content')

<meta name="viewport" content="width=device-width, initial-scale=1.0"> 


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


<div class="container">
    <div class="lado esquerdo">
        <button class="botao_projetos" >Adicionar</button>
        <img src="{{ asset('images/pdf.png') }}" width=30px style='position: fixed;
    top: 205px; left: 50px'></img> <a href="#" style='position: fixed;
    top: 210px; left: 110px;'>Ver Enunciado</a>
    <img src="{{ asset('images/excel.png') }}" width=30px style='position: fixed;
    top: 265px; left: 50px'></img> <a href="#" style='position: fixed;
    top: 270px; left: 110px;'>Abrir Excel </a>

    <img src="{{ asset('images/note.png') }}" width=30px style='position: fixed;
    top: 325px; left: 50px'></img> <a href="#" id="create" style='position: fixed;
    top: 330px; left: 110px;'>Bloco de Notas </a>
    
    </div>
    <div class="lado direito">
        <p class="grupos"> Grupos inscritos:</p>
        
    </div>
</div>


<script>

$("#create").click(function() {
  $(this).before("<textarea></textarea>");
  
});




</script>


@endsection


