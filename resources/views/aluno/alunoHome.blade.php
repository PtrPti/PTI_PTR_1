@extends('layouts.app_aluno')

@section('content')

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
    <div class="dropdown">
      <h4 style="margin:15px;margin-right: 30px;"> Projetos </h4>
      <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="#" style="background-color: #eee9e9;">
        <img src="{{ asset('images/filter.png') }}" class="filtro_projeto">
      </a>
      <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="top: 24px;left: -56px;">
        <li class="dropdown-item">
          <input type="checkbox" id="favoritos" />
          <label for="favoritos">Favoritos</label>
        </li>
        <li class="dropdown-item">
          <input type="checkbox" id="em_curso" />
          <label for="em_curso">Em curso</label>
        </li>
        <li class="dropdown-item">
          <input type="checkbox" id="terminados" />
          <label for="terminados">Terminados</label>
        </li>
      </ul>
    </div>

    <div class="grupo">
      @if (count($projetos) == 0)
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
      @endif
    </div>
  </div>
</div>
@endsection
