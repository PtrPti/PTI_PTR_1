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
            @foreach ($cadeiras as $disciplina)
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
  </div>          
</div>

<div class="homeAluno">    
  <div class="divDisciplinas">
      <h4 style="margin-left:15px;">Disciplinas</h4>
      <div class="disciplina">
          @foreach ($cadeiras as $disciplina)
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
          
          <button type='button' class="filtro_btn" onclick="filterProj()">Aplicar</button>
          <!-- <button type='button' onclick="filterProj()">Aplicar</button> -->
        </div>
        <!-- </form> -->
      </ul>
    </div>

    <!-- <div class="grupo"> -->
      <!-- @if (count($projetos) == 0)
          <p>Não está inscrito em nenhum projeto/grupo</p>                                   
      @else
          @foreach ($projetos as $proj)
          <a href="{{ route('pagProjeto', ['id' => $proj->id]) }}">
              <div>
                  {{$proj->projeto}} | Grupo Nº{{$proj->numero}}<br>
                  <small>{{$proj->cadeiras}}</small>
              </div>
          </a>
          @endforeach 
      @endif -->
      @include('aluno.filtroProjeto')
    <!-- </div> -->
  </div>
</div>

<script>
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
